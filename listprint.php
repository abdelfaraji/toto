<?php

function edit($collection,$filiere,$pdf,$bac){
	
    		$pdf->cell(0,10,utf8_decode("Liste des candidats : $bac"),0,1,"C");
    		$pdf->cell(10,5,utf8_decode("N°"),1,0);
    		$pdf->cell(30,5,"CNE ",1,0);
    		
    		$pdf->cell(60,5,utf8_decode(" Nom et Prénom"),1,0);
    		$pdf->cell(15,5,"Moy bac ",1,0);
    		$pdf->cell(20,5," bac ",1,0);
    		$pdf->cell(50,5,"Direction Provinciale",1,1);
    		$pdf->SetFont('arial','',10); 

    		$l=0;$i=1;
    		//echo "trouve";
    		while($tabCandidat=$collection->fetch_assoc())
    		{
    		//$pdf->SetTopMargin(2); 
    		$pdf->cell(10,5,$i,1,0);
			$pdf->cell(30,5,$tabCandidat['cne'],1,0);
    		$pdf->cell(60,5,$tabCandidat['nom']. " ".$tabCandidat['prenom'],1,0);
    		$pdf->cell(15,5,$tabCandidat['noteBac'],1,0);
    		$pdf->cell(20,5,$tabCandidat['bac'],1,0);
    		$pdf->cell(50,5,$tabCandidat['directionProv'],1,1);
    		$l++;$i++;

    	if($l==40){
    		$l=0;
    		$pdf->AddPage();
    		$pdf->SetFont('arial','B',10); 
    		$pdf->cell(0,10,utf8_decode("Liste des candidats de la filière ".$filiere ." qui se sont présentés: autres bac"),0,1,"C");
    		$pdf->cell(30,5,"CNE ",1,0);
    		$pdf->cell(30,5,"Nom ",1,0);
    		$pdf->cell(45,5,utf8_decode("Prénom"),1,0);
    		$pdf->cell(15,5,"Moy bac ",1,0);
    		$pdf->cell(20,5," bac ",1,0);
    		$pdf->cell(50,5,"Direction Provinciale",1,1);
    		$pdf->SetFont('arial','',10); 

			}
		}
	}
    $con=new mysqli('localhost','root','','selectbts');
    include('fpdf.php');
    
    		$pdf=new FPDF("P", "mm", "A4"); 
			$pdf->SetFont('Arial','',7); 
			//FPDF("p", "pt", A5); 
			$pdf->SetTopMargin(2); 
			$pdf->SetAutoPageBreak(TRUE, 1); 
			

    //Ajout de consommation

    if(isset($_POST['print']))
    {
    	
    	$filiere=$_POST['filiere'];
    	$pdf->AddPage(); 
	
    	//echo $periode;
    	//$police = $_POST['police'];*/
    	$result=$con->query("SELECT * FROM candidats WHERE  filiere='$filiere' and presente=1 and cat ='autres' order by noteBac DESC");
    	$pdf->SetFont('Times','I',10); 
			$pdf->multicell(50,5,utf8_decode("Lycée Technique qualifiant \n Brevet de Technicien Supérieur\n ERRACHIDIA"),0,'C');
			$pdf->setxy(70,3);
			$pdf->setfillcolor(200,200,200);
			$pdf->multicell(50,5,utf8_decode("PV d'appellation n°    \n Liste des appelés \n filière: $filiere"),1,'C',true);
			$pdf->setxy(140,3);
			$pdf->multicell(50,5,utf8_decode("Année Scolaire             \n Le              \n à        "),0,'C');
    	if($result->num_rows>0)
    	{	

    		edit($result,$filiere,$pdf,"autres bac");
    	}
    	$result=$con->query("SELECT * FROM candidats WHERE  filiere='$filiere' and presente=1 and cat ='tech' order by noteBac DESC");
    	if($result->num_rows>0)
    	{	$pdf->SetFont('Times','I',10); 
    		$pdf->AddPage(); 
    		edit($result,$filiere,$pdf," bac technique");
    	}




			//$pdf->cell(75,6,utf8_decode("Net à payer :   ").$montantNet,0,0);

			
			
//$
    			
    			
    			
    		
    	}$pdf->output();
    
