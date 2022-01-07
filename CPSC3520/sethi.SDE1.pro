%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
% ECE3520/CpSc3520 SDE1: Prolog Declarative and Logic Programming

% Use the following Prolog relations as a database of familial 
% relationships for 4 generations of people.  If you find obvious
% minor errors (typos) you may correct them.  You may add additional
% data if you like but you do not have to.

% Then write Prolog rules to encode the relations listed at the bottom.
% You may create additional predicates as needed to accomplish this,
% including relations for debugging or extra relations as you desire.
% All should be included when you turn this in.  Your rules must be able
% to work on any data and across as many generations as the data specifies.
% They may not be specific to this data.

% Using SWI-Prolog, run your code, demonstrating that it works in all modes.
% Log this session and turn it in with your code in this (modified) file.
% You examples should demonstrate working across 4 generations where
% applicable.

% Fact recording Predicates:

% list of two parents, father first, then list of all children
% parent_list(?Parent_list, ?Child_list).

% Data:

parent_list([fred_smith, mary_jones],
            [tom_smith, lisa_smith, jane_smith, john_smith]).

parent_list([tom_smith, evelyn_harris],
            [mark_smith, freddy_smith, joe_smith, francis_smith]).

parent_list([mark_smith, pam_wilson],
            [martha_smith, frederick_smith]).

parent_list([freddy_smith, connie_warrick],
            [jill_smith, marcus_smith, tim_smith]).

parent_list([john_smith, layla_morris],
            [julie_smith, leslie_smith, heather_smith, zach_smith]).

parent_list([edward_thompson, susan_holt],
            [leonard_thompson, mary_thompson]).

parent_list([leonard_thompson, list_smith],
            [joe_thompson, catherine_thompson, john_thompson, carrie_thompson]).

parent_list([joe_thompson, lisa_houser],
            [lilly_thompson, richard_thompson, marcus_thompson]).

parent_list([john_thompson, mary_snyder],
            []).

parent_list([jeremiah_leech, sally_swithers],
            [arthur_leech]).

parent_list([arthur_leech, jane_smith],
            [timothy_leech, jack_leech, heather_leech]).

parent_list([robert_harris, julia_swift],
            [evelyn_harris, albert_harris]).

parent_list([albert_harris, margaret_little],
            [june_harris, jackie_harrie, leonard_harris]).

parent_list([leonard_harris, constance_may],
            [jennifer_harris, karen_harris, kenneth_harris]).

parent_list([beau_morris, jennifer_willis],
            [layla_morris]).

parent_list([willard_louis, missy_deas],
            [jonathan_louis]).

parent_list([jonathan_louis, marsha_lang],
            [tom_louis]).

parent_list([tom_louis, catherine_thompson],
            [mary_louis, jane_louis, katie_louis]).

%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
% SWE1 Assignment - Create rules for:

% male(?Person).
male(P) :- parent_list([P|_],_).

% female(?Person).
female(P) :- parent_list([_|P],_).

% parent(?Parent, ?Child).
parent(P, C) :- parent_list(PL, CL), member(P, PL), member(C, CL).

% married(?Husband, ?Wife).
married(H, W) :- parent_list(PL, _), member(H, PL), member(W, PL), H \= W.

% ancestor_cnt(?Ancestor, ?Person, ?Number).
ancestor_cnt(A, P, N) :- parent(A, P), N is 1;parent_list(PL,CL), member(A, PL), member(C, CL), ancestor_cnt(C,P,N2), N is N2 + 1.

% ancestor(?Ancestor, ?Person).
ancestor(A, P) :- ancestor_cnt(A, P, _).

% descendent(?Descendent, ?Person).
descendent(D, P) :- ancestor(P, D).

% common_ancestor(?Person1, ?Person2, ?Ancestor).
common_ancestor(P1, P2, A) :- descendent(P1, A), descendent(P2, A).

% blood(?Person1, ?Person2). %% blood relative.
blood(P1, P2) :- descendent(P1, A), descendent(P2, A); ancestor(P1, P2); ancestor(P2, P1).

% sibling(?Person1, Person2).
sibling(P1, P2) :- parent_list(_, CL), P1 \= P2, member(P1, CL), member(P2, CL).  

% father(?Father, ?Child).
father(F, C) :- parent_list([P|_], CL), F = P, member(C, CL). 

% mother(?Mother, ?Child).
mother(M, C) :- parent_list([_|P], CL), M = P, member(C, CL). 

% uncle(?Uncle, ?Person). %% 
uncle(U, P) :- parent_list(PL, CL), member(P, CL), member(X, PL), sibling(U, X), male(U). 

% aunt(?Aunt, ?Person). %% 
aunt(A, P) :- parent_list(PL, CL), member(P, CL), member(X, PL), sibling(A, X), female(A).

% Least Common Ancestor lca(?Person1, Person2, ?Ancestor).

lca(P1,P2,A) :- father(A,P1), father(A,P2), P1 \== P2.

lca(P1,P2,A) :- father(A,P1), father(A,P4), P1 \== P4, ancestor(P4, P2).

lca(P1,P2,A) :- father(A,P3), ancestor(P3,P1), father(A,P2), P3\== P2.

lca(P1,P2,A) :- father(A,P3), ancestor(P3, P1), father(A,P4), P3 \== P4, ancestor(P4, P2).

% cousin(?Cousin, ?Person).
cousin(P1, P2) :- cousin_type(P1, P2, _, _).

%% 1st cousin, 2nd cousin, 3rd once removed, etc.
% cousin_type(+Person1, +Person2, -CousinType, -Removed).

cousin_type(P1, P2, T, R) :- lca(P1, P2, A), ancestor_cnt(A,P1,C1), ancestor_cnt(A,P2,C2), C1 > 1, C2 > 1, T is (min(C1, C2)-1), R is abs(C1-C2).
