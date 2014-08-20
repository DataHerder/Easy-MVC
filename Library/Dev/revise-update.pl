#!/usr/bin/perl
use strict;
use warnings;
use FindBin;
use Getopt::Long;
use Data::Dumper;


# this script is set to revise the update data that the update
# script works off of to update a particular directory with the new
# EasyMVC architecture

# ignore these directories
my @ignored_directories = ('Application', 'Media', 'Cron');
my %ignored_directories = map { $_ => 1 } @ignored_directories;

#the htaccess data
my %htaccess = ();

#
# first open up the .htaccess file
#

open HTACCESS, '< ../../.htaccess' || die $!;
open SAVE, '>update/update-data' || die $!;

my $check = 0;
my $back_ref = '';
while (<HTACCESS>) {
	# chomp the line
	chomp;
	$_ = trim($_);

	if ($check == 1) {
		htaccessParseLine($_, $back_ref);
	}
	$check = 0;
	# check for the ignore
	if ($_ =~ /\=\= (\{\w+\})/) {
		$back_ref = $1;
		$check = 1;
	}
}
close HTACCESS;



# save the files to update
opendir(D, "../../") || die $!;
my @list = grep !/^\.+$|\.idea|\.D|\.git/, readdir(D);
closedir(D);


%finished_list = ();


dirFind(\@list, "../../", 'root', \%finished_list);


sub dirFind
{
	my $list_ = shift;
	my $dir_ = shift;
	my $root_dir = shift;
	my $hash_ref = shift;
	my %hash_save = %$hash_ref;
	my %new_hash = ();

	for my $z ( 0 .. scalar(@$list_)-1 ) {
		my $file_name = ${$list_}[$z];
		if (-d $dir_.$file_name) {
			if ($root_dir eq 'root' && exists($ignored_directories{$file_name})) {
				next;
			} else {
				$hash_ref
			}
			#print $file_name."\n";
		} else {
			$finished_list{$root_dir}{$file_name} = 1;
		}
		#my $file_path = "$FindBin::Bin/".$dir_;
		#print $file_path;

	}
}



## print the htaccess
print SAVE "HTACCESS:";
my @tmp = ();
for my $x(sort {lc $a cmp lc $b} keys %htaccess) {
	push @tmp, $x."===".$htaccess{$x};
}
print SAVE join '||', @tmp;

close SAVE;


sub htaccessParseLine
{
	my $htax = shift;
	my $bref = shift;
	my $ht = shift;
	$bref =~ s/\{|\}//g;
	$htaccess{$bref} = $htax;
}

sub trim
{
	my $a = shift;
	$a =~ s/^\s+//;
	$a =~ s/\s+$//;
	return $a;
}