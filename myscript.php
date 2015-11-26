<html> 
<head>
<title>Result of Database Query</title>
</head>
<body> 
<p>
<b>Author : </b>
<a>Hanno Nickau</a>
<h1>Result of Database Query</h1>
<?php
  $dbconn = pg_connect("host=tr01")
    or die('Could not connect: ' . pg_last_error());

 if(!empty($_POST['cno'])) {
  // Prepare a query for execution with $1 as a placeholder
  $result = pg_prepare($dbconn, "my_query", 'SELECT student.sname, enroll.grade FROM student, enroll WHERE student.sid=enroll.sid AND enroll.cno = $1')
    or die('Query preparation failed: ' . pg_last_error());

  // Execute the prepared query with the value from the form as the actual argument 
  $result = pg_execute($dbconn, "my_query", array($_POST['cno'])) 
    or die('Query execution failed: ' . pg_last_error());

  $nrows = pg_numrows($result);
    if($nrows != 0)
      {
	print "<p>Data for course: " . $_POST['cno'];
	print "<table border=2><tr><th>Name<th>Grade\n";
	for($j=0;$j<$nrows;$j++)
		{
			$row = pg_fetch_array($result);
			print "<tr><td>" . $row["sname"];
			print "<td>" . $row["grade"];
			print "\n";
		}
		print "</table>\n";
	}
	else	print "<p>No Entry for " . $_POST['studentid'];
}

if (!empty($_POST['age'])) {

  // Prepare a query for execution with $1 as a placeholder
  $result = pg_prepare($dbconn, "my_query", 'SELECT count(major.sid), major.dname FROM student JOIN major ON student.sid = major.sid WHERE student.age < $1 GROUP BY major.dname')
    or die('Query preparation failed: ' . pg_last_error());

  // Execute the prepared query with the value from the form as the actual argument 
  $result = pg_execute($dbconn, "my_query", array($_POST['age'])) 
    or die('Query execution failed: ' . pg_last_error());

  $nrows = pg_numrows($result);
    if($nrows != 0)
      {
	print "<p>Data for age: " . $_POST['age'];
	print "<table border=2><tr><th>Department<th>Number of Majors\n";
	for($j=0;$j<$nrows;$j++)
		{
			$row = pg_fetch_array($result);
			print "<tr><td>" . $row["dname"];
			print "<td>" . $row["count"];
			print "\n";
		}
		print "</table>\n";
	}
	else	print "<p>No Entry for " . $_POST['age'];
}

if (!empty($_POST['num'])) {

  // Prepare a query for execution with $1 as a placeholder
  $result = pg_prepare($dbconn, "my_query", 'SELECT A.cno, A.sectno FROM (SELECT enroll.cno, enroll.sectno, count(enroll.sid) FROM enroll GROUP BY enroll.cno, enroll.sectno) A WHERE A.count < $1')
    or die('Query preparation failed: ' . pg_last_error());

  // Execute the prepared query with the value from the form as the actual argument 
  $result = pg_execute($dbconn, "my_query", array($_POST['num'])) 
    or die('Query execution failed: ' . pg_last_error());

  $nrows = pg_numrows($result);
    if($nrows != 0)
      {
	print "<p>Data for max number: " . $_POST['age'];
	print "<table border=2><tr><th>Course no<th>Section no\n";
	for($j=0;$j<$nrows;$j++)
		{
			$row = pg_fetch_array($result);
			print "<tr><td>" . $row["cno"];
			print "<td>" . $row["sectno"];
			print "\n";
		}
		print "</table>\n";
	}
	else	print "<p>No Entry for " . $_POST['num'];
}
	pg_close($dbconn);
?>
</p>
</body>
</html>
