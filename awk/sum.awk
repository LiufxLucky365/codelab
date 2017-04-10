BEGIN {
	print "sum ...";
	sum = 0;
}

{
	sum = sum + $0;
	print sum;
}

END {
	print "sum = " sum;
}
