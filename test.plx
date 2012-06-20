#!/user/bin/perl
use strict; use warnings;
use LWP::Simple; #For https sites.
use DBI; #To interact with the db 
use DBD::mysql; #To use MySQL db
use warnings;

print "Script started at ", scalar localtime, "\n";
my $url = 'https://listings.och.uwaterloo.ca/Listings/Search/Results?ps=50';
my $browser = LWP::UserAgent->new; my $response = $browser->get($url);
my $content; my $directions; 
my $to_db = 1; #0 = No Database, 1 = Database
my $db_table = "temp";

if ($response->is_success) {
    print "Success: internet connection! Extracting OCH content...\n";
    $content = get($url);
} else {
    print "Fail whale: no internet connection.\n"; die;
}

##########################
########CLEANING##########
##########################
my $number_of_pages = getNumListings(); my $cur_url; my @cur_rentalIds;
print "There are $number_of_pages pages of listings.\n";
my @new_rentalIds = getrentalIds($content);
print "Now to get the existing rentalIds from the database.\n";
my ($dbh, $sql, $sth, @errors);

die "Connection Error\n" unless $dbh = DBI->connect ("DBI:mysql:studen89_turtle","studen89_admin", 'Nakatian1!'); print "\nConnected to the database.\n";

#########First, we get the existing listings from the database.
$sql = "SELECT rentalId FROM $db_table"; $sth = $dbh->prepare($sql);
my $results = $dbh->selectall_hashref($sql,'rentalId');
my @old_rentalIds = keys (%$results); $sth->finish(); 
print "We have the exising listings, now we're removing them.\n";

#########Now to remove the existing listings from the database.
my @to_delete = get_old_listings(\@new_rentalIds, \@old_rentalIds);
if (scalar @to_delete == 0) {
    print "All listings in the database still exist--none will be deleted.\n";
}
for (@to_delete) {
    $sql = "DELETE FROM $db_table WHERE rentalId = $_";
    $sth = $dbh->prepare($sql);
    if (not($sth->execute())) {
	print "Error when trying to delete rentalId: $_\n";
    } else {
	print "$_ has been deleted from the database.\n";
    }
    $sth->finish();
}
$dbh->disconnect(); 

#########Now to verify the new ones to add.
print "We are now going to look at the rentalIds we can add.\n";
print "Originally, we had potentially ",scalar @new_rentalIds," new rentalIds.\n";
my @rentalIds = get_new_listings(\@new_rentalIds, \@old_rentalIds);
if (scalar @rentalIds == 0) {
    print "We have no new listings to add.\n";
} else {
    print "We have ",scalar @rentalIds," listings to add.\n";
}
for (@rentalIds) {
    print "$_ will be added.\n";
}

########################
#######EXTRACTION#######
########################
my @addresses; my @avails; my @totalrooms; my @emptyrooms; my @costs; my @leasereqs; my @minreqs; my @maxreqs;
my @genders;  my @utils; my @furnished; my @descripts; my @good_rentalIds; my @emails; my @phones; my @ratings, my @distances;
my @lats; my @longs;

my $count = scalar @rentalIds;
for (@rentalIds) {
    my $rentalId = $_;
    print "Currently on: $_. $count left.\n";
    (my $address, my $avail, my $emptyroom, my $totalroom, my $cost, my $leasereq, my $minreq, my $maxreq, my $gender, my $util, my $furnish, my $descript, my $email, my $phone, my $rating, my $distance, my $lat, my $long) = getInfo($_);
    if (not(defined($address))) {
	$count --; next;
    } #The next few lines is to add in each detail.
    push @good_rentalIds, $rentalId; push @addresses, $address;
    push @avails, $avail; push @emptyrooms, $emptyroom;
    push @totalrooms, $totalroom; push @costs, $cost;
    push @leasereqs, $leasereq; push @minreqs, $minreq;
    push @maxreqs, $maxreq; push @genders, $gender;
    push @utils, $util; push @furnished, $furnish;
    push @descripts, $descript; push @emails, $email;
    push @phones, $phone; push @ratings, $rating; push @distances, $distance;
    push @lats, $lat; push @longs, $long; $count --;
}

@rentalIds = @good_rentalIds;
for (0..$#rentalIds) {
    last;
    print "RentalID: $rentalIds[$_]\nAddress: $addresses[$_]\nAvail: $avails[$_]\nRooms Avail: $emptyrooms[$_]\nTotal Rooms: $totalrooms[$_]\nCost: $costs[$_]\nLease Required: $leasereqs[$_]\nMin Lease Req: $minreqs[$_]\nMax Lease Allowed: $maxreqs[$_]\nGender Preferred: $genders[$_]\nUtilities Included: $utils[$_]\nFurnished: $furnished[$_]\nDescription: $descripts[$_]\nEmail: $emails[$_]Phone Number: $phones[$_]\nRating: $ratings[$_]\nDistance: $distances[$_]\nLatitude: $lats[$_]\nLongitude: $longs[$_]\n\n";
}

#########################
######MySQL TIME#########
#########################
if (scalar @rentalIds == 0) {
    print "\nWe have no new listings to add. Script will terminate.\n";
    print "Script ended at ", scalar localtime, "\n"; die;
}

print "Done going through the listings; trying to connect to database.\n";
die "Offline mode--not going to database\n" unless $to_db == 1;
die "Connection Error\n" unless $dbh = DBI->connect ("DBI:mysql:studen89_turtle", "studen89_admin", 'Nakatian1!');
print "Connected to the database: inserting results.\n";

for (0..$#rentalIds) {
    $sql = "INSERT INTO $db_table VALUES('$rentalIds[$_]', '$addresses[$_]', '$avails[$_]', '$emptyrooms[$_]', '$totalrooms[$_]', '$costs[$_]', '$leasereqs[$_]', '$minreqs[$_]', '$maxreqs[$_]', '$genders[$_]', '$utils[$_]', '$furnished[$_]', '$descripts[$_]', '$emails[$_]', '$phones[$_]', '$ratings[$_]', '$distances[$_]', '$lats[$_]', '$longs[$_]')";
    $sth = $dbh->prepare($sql);
    if (not($sth->execute())) {
	print "SQL error with rentalId: $rentalIds[$_]\n";
	push @errors, $rentalIds[$_];
    }
    $sth->finish()
}
if (scalar @errors == 0) {
    print "Everything seems to have gone perfectly.\n";
} else {
    print "There were ", scalar @errors, " errors: @errors\n";
}
$dbh->disconnect();
print "We have now disconnected from the database.\n";
print "Script ended at ", scalar localtime, "\n";

###################################
############Subroutines############
###################################
#All the subroutines are kept here, to make the code above readable.

#########################
######getNumListings#####
#########################
#Used in counting how many pages of listings there are
#getNumlistings: (none) -> int
sub getNumListings {
    my $number_of_pages = 0;
    $number_of_pages++ while ($content =~ /font-size: 12/g);
    $number_of_pages = $number_of_pages/2+0.5;
    return $number_of_pages;
}

########################
######getrentalIds######
########################
#Used in retrieving all the rentalIds from a page
#getrentalIds: $content {which is the pagesource of a page} -> @rentalIds
sub getrentalIds {
    for (1..$number_of_pages) {
	if ($_ == 1) {
	    my @rentalIds = (); my $content = shift;
	} else {
	    $cur_url = $url . "&page=$_";
	    $content = get($cur_url);
	}
	while ($content =~ /(rentalId=)(\d{5})/g) {
	    push @rentalIds, $2;
	}
	print "Got the listings for page: $_\n";
    }
    my %hash = map {$_, 1} @rentalIds;
    @rentalIds = sort keys %hash;
    return @rentalIds;
}

##############################
#####get_new/old_listings#####
##############################
#It returns all the rentalIds you need to add.
#get_new_listings(@new,@old)
sub get_new_listings{
    my(@new) = @{$_[0]}; my(@old) = @{$_[1]};
    my %old_hash = map {$_, 1} @old; my @to_add;
    for (@new) {
	if (not(defined($old_hash{$_}))) {
	    push (@to_add, $_);
	}
    }
    return @to_add;
}
    
#It returns all the rentalIds you need to remove.
#get_old_listings(@new, @old)
sub get_old_listings{
    my(@new) = @{$_[0]}; my(@old) = @{$_[1]};
    my %new_hash = map {$_, 1} @new; my @to_delete; 
    for (@old) {
	if (not(defined($new_hash{$_}))) {
	    push(@to_delete, $_);
	}
    }
    return @to_delete;
}

##########################
#######getInfo############
##########################
#Returns address, start date of available, empty rooms, total rooms, cost, is lease required, min required lease, max allowed, if utilities are included and a description/remarks, and empty rating and random distance
sub getInfo {
    my $rentalId = shift;
    my $url = join ("", 'https://listings.och.uwaterloo.ca/Listings/Details/Show?rentalId=', $rentalId);
    my $browser = LWP::UserAgent->new; my $response = $browser->get($url);
    my $content = get($url); #the pagesource is now $content
    my $temp = 0; my @info; my $address; my $total_vacancies; 
    my $total_people; my $cost; my $descript; my $rating = 0; my $lat = 0; my $long = 0;
    
    #calculate random distance
    #my $random_number = rand(30) + 1;
    my $distance;
    $distance = 0;

    if ($content =~ /no longer available/) {
	return ();
	last;
    }

    while ($content =~ /(.*?)<br/g) { #searches the entire page source
	if ($temp == 4) {
	    $address = $1;
	    $address =~ /(\S.*?)$/;
	    $address = $1;
	    $address .= ", ";
	}
	if ($temp == 5) {
	    my $city = $1;
	    $city =~ /(\S.*?)$/;
	    $address .= $1;
	    $_ = $address; s/'//g; $address = $_; #In case of apostrophes
	    push(@info, $address); 
	    last;
	}
	$temp++;
    }
    while ($content =~ /Available.*?<td>.*?(Now|\w.*?,\s\d+)/s) {
	push(@info, $1);
	last;
    }
    while ($content =~ /Vacancies.*?(\d+)\s+of\s+(\d+)/s) {
	push(@info, $1);
	push(@info, $2);
	$total_vacancies = $1;
	$total_people = $2;
	last;
    } 
    if ($content =~ /Rent.*?\$(\d+).*?(Per (Person|Unit)) (Per (Week|Month))/s) {
	if ("Per Person" eq $2) {
	    if ("Per Week" eq $4) {
		$cost = $1; $cost *= 4.34; #Average weeks/month
		push(@info, $cost);
	    } else {
		push(@info, $1);
	    }
	} elsif ("Per Unit" eq $2) {
	    my $true_cost = $1;
	    $cost = $1 / $total_vacancies;
	    if ($cost < 201) { #Arbitrary number.
		if ($content =~ /Room Type.*?(\d).*?Gender/s) {
		    $cost = $true_cost / $1;
		} else {
		    $cost = $cost * $total_vacancies;
		}
	    } elsif ($content =~ /Room Type.*?(\d).*?Gender/s) {
		$cost = $true_cost / $1;
	    }	
	    if ($cost < 201) {
		$cost = $true_cost;
	    }
	    push (@info, $cost);
	}
    }
    if ($content =~ /Lease.*?Not R/s) {
	push(@info, "No");
    } else {
	push(@info, "Yes");
    }
    while ($content =~ /Min Required.*?(\d+)/s) {
	push(@info, $1);
	last;
    }
    if ($content =~ /Max Allowed.*?(\d+)/s) { #Sometimes it's not listed
	push (@info, $1);
    } else { #So in that case, we just set it to No Limit
	push (@info, "No Limit");
    }

    if ($content =~ /Gender.*?Male/s) {
	push(@info, "M");
    } elsif ($content =~ /Gender.*?Female/s) {
	push(@info, "F");
    } else {
	push(@info, "All");
    }
    
    if ($content =~ /Utilities Extra/) {
	push (@info, "No");
    } else {
	push (@info, "Yes");
    }

    if ($content =~ /Furnished/) {
	push (@info, "Yes");
    } else {
	push (@info, "No");
    }

    if ($content =~ /Remarks.*?<br \/>.*?<br \/>\s+(\S.*?)\s+<\/div>/s) {
	$descript = $1;
	$descript =~ s/\s{3,}/ /g; #This replace all whitespaces(3+) with just one.
	$descript =~ s/'|"//g; #Quotation marks suck too
	push (@info, $descript);
    } else {
	push (@info, "No Description");
    }

    if ($content =~ /mailto:(.*?)\?/) {
	push (@info, $1);
    } else {
	push (@info, "None");
    }

    if ($content =~ /<br.>(.*?\d+)\s+(<|\w)/s) { #Phone number
	push (@info, $1);
    } else {
	push (@info, "None");
    }
	#rating
	push (@info, $rating);
	push (@info, $distance);
	push (@info, $lat);
	push (@info, $long);
    return @info;
}
