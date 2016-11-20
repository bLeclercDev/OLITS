<?php 

function connectBddT()
{
	$hostname="localhost";
	$user="root";
	$password='';
	$dbname='gestmedia';
	$mysqli =mysqli_connect($hostname,$user,$password,$dbname);	
	if(mysqli_connect_error()) // affiche une erreur si la connexion échoue
	{
		die('Erreur('.mysqli_connect_errno() . ') ' . mysqli_connect_error());
	}
	$search = 'Mandela';
	$stmt = mysqli_prepare($mysqli, "SELECT nom, prenom FROM personne WHERE nom LIKE ?");
	mysqli_stmt_bind_param($stmt, "s", $search);
	mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $firstName, $lastName);
	while (mysqli_stmt_fetch($stmt)) {
        printf ("%s %s <br>", $firstName, $lastName);
    }	
	mysqli_stmt_close($stmt);
	mysqli_close($mysqli ); // ferme la connexion bdd

}
?>