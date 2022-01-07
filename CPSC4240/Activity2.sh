#!/bin/bash

s=$#;

if test $s -lt 1; then
	echo "Not enough command-line arguments";
	exit 1;
else
	for c in "$@"
	do
		if [[ -d $c ]]; then
		echo "$c is a directory";
		elif [[ -f $c ]]; then
		echo "$c is a file";
		else
		echo "$c is neither file nor directory";
		fi
	done
fi
