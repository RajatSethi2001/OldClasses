#include "region.h"

void init_region( region_t *r, int max ) {
  r->signature = 0xDDA89BAA;
  r->count = 0;
  r->max_count = max;
  pthread_mutex_init(&r->lock, NULL);
  pthread_cond_init(&r->delay_cv, NULL);
  r->inside_region_list = (pthread_t*)calloc(r->max_count, sizeof(pthread_t));
}

void enter_region( region_t *r, int (* predicate)() ) {
  if( r->signature != 0xDDA89BAA ){
    printf("Thread trying to enter an uninitialized region.\n" );
    pthread_exit(NULL);
  }

  pthread_mutex_lock(&r->lock);

  while(r->count >= r->max_count || predicate() == 0) {
      pthread_cond_wait(&r->delay_cv, &r->lock);
  }

  for (int i = 0; i < r->max_count; i++) {
    if (pthread_equal(pthread_self(), r->inside_region_list[i])) {
      printf("Thread calling enter_region() was already inside region.\n" );
      pthread_mutex_unlock(&r->lock);
      pthread_exit(NULL);
    }
  }

  for (int i = 0; i < r->max_count; i++) {
    if (r->inside_region_list[i] == 0) {
      r->inside_region_list[i] = pthread_self();
      r->count++;
      break;
    }
  }

  pthread_mutex_unlock(&r->lock);
  return;
}

void exit_region( region_t *r ) {
  if( r->signature != 0xDDA89BAA ){
    printf("Thread trying to enter an uninitialized region.\n" );
    pthread_exit(NULL);
  }

  pthread_mutex_lock(&r->lock);

  int threadIndex = -1;
  for (int i = 0; i < (r->max_count); i++) {
    if (pthread_equal(pthread_self(), r->inside_region_list[i])) {
      threadIndex = i;
      break;
    }
  }

  if (threadIndex < 0) {
    printf("Thread calling exit_region() was not inside region.\n" );
    pthread_mutex_unlock(&r->lock);
    pthread_exit(NULL);
  }

  r->inside_region_list[threadIndex] = 0;
  r->count--;
  pthread_cond_broadcast(&r->delay_cv);
  pthread_mutex_unlock(&r->lock);
  return;
}

void finalize_region( region_t *r ) {
  if( r->signature != 0xDDA89BAA ){
    printf("Parent trying to finalize an uninitialized region.\n" );
    return;
  }

  pthread_mutex_destroy(&r->lock);
  pthread_cond_destroy(&r->delay_cv);
  free(r->inside_region_list);

  if (r->count != 0) {
    printf("%d threads left inside a region.\n", r->count);
  }
  return;
}

int true_predicate() {
  return 1;
}