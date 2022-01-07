//     *********************************
//     *    Matrix Multiply Project    *
//     *                               *
//     *********************************

//     ** MAIN PROGRAM  **


//     *************************************************
//     ** Any changes you make to this code must      **
//     ** maintain the correctness of the matrix      **
//     ** multiply computed by the original version.
//     **					      **
//     ** An implementation with incorrect results for**
//     ** matrix C earns zero point for this project. **
//     ** 
//     ** To print matrix compile with -DPRINT_MATRIX **
//     ** e.g., g++ -DPRINT_MATRIX                    **
//     **                                             **
//     ** A sample Makefile is provided.
//     ** You may assume m = n = k for your matrices  **
//     *************************************************

#include <stdio.h>
#include <stdlib.h>
#include <sys/time.h>

#define BS 50

double **dmatrix(int nrl,int nrh,int ncl,int nch);
void nerror(char *error_text);

int main(int argc, char** argv)  {
 
      register int l,m,n,k;
      register int i,j, ii, jj, ll;
      register double temp;
      double **A, **B, **C;
      struct timeval start_time;
      struct timeval stop_time;


     //  ****************************************************
     //  * The following allows matrix parameters to be     *
     //  * entered on the command line to take advantage    *
     //  * of dynamically allocated memory.  You may modify *
     //  * or remove it as you wish.                        *
     //  ****************************************************

     if (argc != 4) {
       nerror("Usage:  <executable> <m-value> <n-value> <k-value>");
     }
      m = atoi(argv[1]);
      n = atoi(argv[2]);
      k = atoi(argv[3]);

      // *********************************************************
      // * Call the dmatrix() subroutine to dynamically allocate *
      // * storage for the matrix sizes specified by m, n, and k *  
      // *********************************************************

      A=dmatrix(0,m-1,0,k-1);
      B=dmatrix(0,k-1,0,n-1);
      C=dmatrix(0,m-1,0,n-1);

      // *********************************************************
      //  * Initialize matrix elements so compiler does not      *
      //  * optimize out                                         *
      // *********************************************************

      for(i=0;i<m;i++) {
        for(j=0;j<k;j++) {
	  
          A[i][j] = i+j+4.0;
        }
      }

      for(i=0;i<k;i++) {
        for(j=0;j<n;j++) {
          B[i][j] = i+j+5.0;
        }
      }

      for(i=0;i<m;i++) {
        for(j=0;j<n;j++) {
          C[i][j] = 0.0;
        }
      }
          
      // ******************************
      // * Start embedded timing here *
      // ******************************
	
	gettimeofday(&start_time, NULL);

      // **********************************
      // * Perform simple matrix multiply *
      // **********************************
      for(i=0;i<m;i+=BS) {
        for(j=0;j<n;j+=BS) {
          for(l=0;l<k;l+=BS) {
	    for (ii=i;ii<i+BS;ii+=2) {
	      for (jj=j;jj<j+BS;jj+=2) {
		for (ll=l;ll<l+BS;ll+=2) {
            	  C[ii][jj] = C[ii][jj] + B[ll][jj]*A[ii][ll];
		  C[ii][jj] = C[ii][jj] + B[ll+1][jj]*A[ii][ll+1];
		  C[ii][jj+1] = C[ii][jj+1] + B[ll][jj+1]*A[ii][ll];
		  C[ii][jj+1] = C[ii][jj+1] + B[ll+1][jj+1]*A[ii][ll+1];
		  C[ii+1][jj] = C[ii+1][jj] + B[ll][jj]*A[ii+1][ll];
		  C[ii+1][jj] = C[ii+1][jj] + B[ll+1][jj]*A[ii+1][ll+1];
		  C[ii+1][jj+1] = C[ii+1][jj+1] + B[ll][jj+1]*A[ii+1][ll];
		  C[ii+1][jj+1] = C[ii+1][jj+1] + B[ll+1][jj+1]*A[ii+1][ll+1];
		}
	      }
	    }
          }
        }
      }
      // ******************************
      // * Stop embedded timing here  *
      // ******************************
	
	gettimeofday(&stop_time, NULL);
	fprintf(stdout, "Time Elapsed: %0.6f\n\n", (stop_time.tv_sec - start_time.tv_sec) + (stop_time.tv_usec - start_time.tv_usec)/1000000.0);
	
      // **************************************************
      // * Print out a 10 x 10 matrix for testing only    *
      // * Comment out when timing                        *
      // **************************************************

 #ifdef PRINT_MATRIX
      fprintf(stdout, "Here is the matrix A:\n\n");
      for(i=0;i<m;i++) {
        for(j=0;j<k;j++) {
          fprintf(stdout, "%10.2f ",A[i][j]);
        }
        fprintf(stdout, "\n");
      }
      fprintf(stdout, "Here is the matrix B:\n\n");
      for(i=0;i<k;i++) {
        for(j=0;j<n;j++) {
          fprintf(stdout, "%10.2f",B[i][j]);
        }
        fprintf(stdout, "\n");
      }
      fprintf(stdout, "Here is the matrix C:\n\n");
      for(i=0;i<m;i++) {
        for(j=0;j<n;j++) {
          fprintf(stdout, "%10.2f",C[i][j]);
        }
        fprintf(stdout, "\n");
      }
#endif        
        
}
//     **  END MAIN PROGRAM  **

//     ********************************************************
//     *******    BEGIN SUBROUTINES    ************************
//     ********************************************************

double **dmatrix(int nrl,int nrh,int ncl,int nch)
// Allocates a double matrix with range [nrl..nrh][ncl..nch]
{
  int i;
  double **m;

//    Allocate pointers to rows
  m=(double **) malloc((unsigned)(nrh-nrl+1)*sizeof(double *));
  if (!m) nerror("allocation failure in malloc in dmatrix()");
  m -= nrl;
//    Allocate rows and set pointers to them
  for(i=nrl;i<=nrh;i++) {
    m[i]=(double*) malloc((unsigned) (nch-ncl+1)*sizeof(double));
    if (!m[i]) nerror("allocaion failure in malloc in dmatrix()");
    m[i] -= ncl;
  }
  return m;
}

void nerror(char *error_text)
{
  void exit();
  fprintf(stderr, "Run-time error...\n");
  fprintf(stderr,"%s\n",error_text);
  fprintf(stderr,"Exiting...\n");
  exit(1);
}
