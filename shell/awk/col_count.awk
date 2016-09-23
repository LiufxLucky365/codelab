BEGIN { 
	FS = ","
	count = 0 
}

{
for (i=1; i<=NF; i++) {
	if (i != 6) {
		printf $i "\t"
	}
}
print ""
}

END { 
	# print count 
}

