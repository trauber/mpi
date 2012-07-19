mpi
===

Search Moorestown, NJ Newspaper Indexes - Mysql and PhP.  This is the
code I hope will be deployed at http://www.moorestown.lib.nj.us/ .
Current test data includes only a subset of the indexed years for the
News Chronicle.  Eventually we'll have more data for that paper and also
data for the Moorestown News, the Newsweekly, and the Moorestown Sun.

## Data Cleanup

See a video explaining data cleanup at
<http://dl.dropbox.com/u/21499508/google-refine.m4v> .

Primary issues:

- many typos in dates
- out of type info in the two sort fields, dates and page numbers
- newlines embedded in some fields; possible causes:
	- word wrap on in office and multiple spaces result in newlines
	- cut and paste into fields?

I don't have ms-office.  It's possible that excel treats embedded newlines
correctly.  However, libreoffice calc and gnumeric do not.  I found a
c program for producing .tsv that treats the embedded lines correctly at
<http://wizard.ae.krakow.pl/~jb/xls2txt/> .



## TODO

- check for term length
- check for english lead article sorting library in php
- add checkboxes for newspapers with News Chronicle and Moorestown Sun checked by default
- add mustache for list output, no columns and search page widget for it on entry page
- validate date format (iso 8601 YYYY-MM-DD)
- <span style="text-decoration: line-through">add spage column to table</span>
- clen data with google refine





