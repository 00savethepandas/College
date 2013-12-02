<link rel="stylesheet" href="main.css" type="text/css">
<?php

// CREDENTIALS
$dsn = 'mysql:host=localhost;dbname=database';
$db_user = 'user';  //  username
$user_pw = 'password';  //  password
$database = 'database';

// Try connection with new PDO object, Connect
try {
    $db = new PDO($dsn, $db_user, $user_pw);
    } catch (PDOException $e){
        $error_message = $e->getMessage();
        echo "Failed to connect to MySQL: " .$error_message;
        #include('database_error.php');
        exit();
}

// Instantiate program
$program = new program();


// BEGIN APPLICATION
class program {
    function __construct() {
        $page='homepage';
        $arg=NULL;
        if(isset($_REQUEST['page'])){
            $page=$_REQUEST['page'];
        }
        if(isset($_REQUEST['arg'])){
            $arg=$_REQUEST['arg'];
        }
        // echo $page
        $page = new $page($arg);
	}
    
	function __destruct() {
    }
}

// ABSTRACT PAGE CLASS
abstract class page{
        public $content;
		public $topEnrollment = 'SELECT * FROM enrollment2011 ORDER BY grandTotl DESC LIMIT 5'; 
        function menu() {
            $menu.='<h3>Navigation</h3>';
			$menu.='<a href="./index.php"> Home &nbsp; &nbsp; &nbsp; </a>';
            $menu.='<a href="./index.php?page=quest1"> No. 1 &nbsp; &nbsp; &nbsp; </a>';
			$menu.='<a href="./index.php?page=quest2"> No. 2 &nbsp; &nbsp; &nbsp; </a>';
			$menu.='<a href="./index.php?page=quest34"> No. 3 & 4 &nbsp; &nbsp; &nbsp; </a>';
			$menu.='<a href="./index.php?page=quest5"> No. 5 &nbsp; &nbsp; &nbsp; </a>';
			$menu.='<a href="./index.php?page=quest6"> No. 6 &nbsp; &nbsp; &nbsp; </a>';
			$menu.='<a href="./index.php?page=quest7"> No. 7 &nbsp; &nbsp; &nbsp; </a>';
			$menu.='<a href="./index.php?page=quest8"> No. 8 &nbsp; &nbsp; &nbsp; </a>';
			$menu.='<a href="./index.php?page=quest9"> No. 9 &nbsp; &nbsp; &nbsp; </a>';			
			$menu.='<a href="./index.php?page=quest10"> No. 10 &nbsp; &nbsp; &nbsp; </a>';
			$menu.='<a href="./index.php?page=quest11"> No. 11 &nbsp; &nbsp; &nbsp; </a>';
			$menu.='<a href="./index.php?page=quest12"> No. 12 &nbsp; &nbsp; &nbsp; </a>';
            return $menu;
        } 

       function __construct($arg=NULL){
            if($_SERVER['REQUEST_METHOD']=='GET'){
                $this->get();
            }
            else{
                $this->post();
            }
        } 
        function __destruct(){
            echo $this->content;
        }
} 

class homepage extends page {
	function get(){
		$this->content.=$this->menu();
		$this->content.=$this->header();
		$this->content.=$this->intro();
	}
	function header(){
		echo '<h1>College Data Project</h1>';		
	}
	function intro(){
		echo '<p>For each type of data file there is a data dictionary contained in the xls file. This file explains the contents of the file. You do not need to import the entire file. You should select the fields that will allow you to answer the questions listed below. You should modify the import for the multi-year files to contain a field that indicates the year that the data comes from, or you should create an additional table that maps the year of the record to the actual record.</p>';
	}	
}


// 1. HIGHEST ENROLLMENT
class quest1 extends page {
	function get(){
		// MENU
		$this->content.=$this->menu();
		$this->content.=$this->header();
		$this->content.=$this->blurb();
		$this->content.=$this->table();	
	}
	
	function Header(){
		echo '<h2>1. Highest Enrollment in 2011</h2>';
	}
	
	function blurb(){
		echo '<p>This page displays the top 5 colleges based on highest enrollment</p>';	
	}
	function table(){
		global $db;
		$topEnrollment = 'SELECT * FROM enrollment2011 ORDER BY grandTotl DESC LIMIT 5'; 
		echo '<table border="1"; cellpadding="5">';
		echo '<tr><th>University Name</th><th>Number Enrolled</th><th>Year</th></tr>';
		foreach($db->query($topEnrollment) as $row){
    		echo '<tr><td>';
    		echo $row['universityName'];
    		echo '</td><td>';
    		echo $row['grandTotl'];
    		echo '</td><td>';
	    	echo $row['year'];
		}
		echo '</td></tr>';
		echo '</table>';
		echo '<br />';
	}
}

// 2. TOTAL LIABILITIES
class quest2 extends page {
function get(){
		// MENU
		$this->content.=$this->menu();
		$this->content.=$this->header();
		$this->content.=$this->blurb();
		$this->content.=$this->table();	
	}
	
	function Header(){
		echo '<h2>2. Total Liabilities: 2011</h2>';
	}
	
	function blurb(){
		echo '<p>This page displays the top 5 colleges with the highest liability.</p>';	
	}	
	
	function table(){
		global $db;
		$lia2011query = 'SELECT * FROM liabilities2011 ORDER BY liabilities2011.totlLiabs DESC LIMIT 5';
		echo '<table border="1"; cellpadding="5">';
		echo '<tr><th>University Name</th><th>Current Liabilities</th><th>Total Liabilities</th></tr>';
		foreach($db->query($lia2011query) as $row){
		    echo '<tr><td>';
		    echo $row['universityName'];
		    echo '</td><td>';
		    echo $row['totlCurLiabs'];
		    echo '</td><td>';
		    echo $row['totlLiabs'];
		    echo '</td></tr>';
		}
		echo '</table>';
		echo '<br />';
	}
}

// 3 - 4. LARGEST AMOUNT OF NET ASSETS
class quest34 extends page {	
	function get(){
		// MENU
		$this->content.=$this->menu();
		$this->content.=$this->header();
		$this->content.=$this->blurb();
		$this->content.=$this->table();	
	}	
	
	function Header(){
		echo '<h2>3. - 4. Highest Net Assets: 2011</h2>';
	}
	
	function blurb(){
		echo '<p>This page displays the top 5 colleges with the highest net assets.</p><p> Question 4 is a duplicate of question 3.</p>';	
	}	
	
	function table(){
		global $db;
		$topNetAssets = 'SELECT * FROM assets2011 ORDER BY assets2011.totlNetAssts DESC LIMIT 5';
		echo '<table border="1"; cellpadding="10">';
		echo '<tr><th>University Name</th><th>Current Assets</th><th>Total Net Assets</th><th>Year</th></tr>';
		foreach($db->query($topNetAssets) as $row){
		    echo '<tr><td>';
		    echo $row['universityName'];
		    echo '</td><td>';
		    echo $row['totlCurAssts'];
		    echo '</td><td>';
		    echo $row['totlNetAssts'];
		    echo '</td><td>';
			echo $row['year'];
			echo '</td></tr>';
		}
		echo '</table>';
		echo '<br />';
	}
}

// 5. LARGEST TOTAL REVENUES
class quest5 extends page {	
	function get(){
		// MENU
		$this->content.=$this->menu();
		$this->content.=$this->header();
		$this->content.=$this->blurb();
		$this->content.=$this->table();	
	}	
	
	function Header(){
		echo '<h2>5. Highest Total Revenues: 2011</h2>';
	}
	
	function blurb(){
		echo '<p>This page displays the top 5 colleges with the highest total revenues.</p>';	
	}	
	
	function table(){
		global $db;
		$topRevenues = 'SELECT * FROM revenue2011 ORDER BY totlRevenue DESC LIMIT 5;';
			echo '<table border="1"; cellpadding="10">';
			echo '<tr><th>University Name</th><th>Total Rvenues</th><th>Year</th></tr>';
			foreach($db->query($topRevenues) as $row){
			    echo '<tr><td>';
			    echo $row['universityName'];
			    echo '</td><td>';
			    echo $row['totlRevenue'];
			    echo '</td><td>';
			    echo $row['year'];
			    echo '</td></tr>';
			}
			echo '</table>';
			echo '<br />';
	}
}

// 6. REVENUE PER STUDENT
class quest6 extends page {	
	function get(){
		// MENU
		$this->content.=$this->menu();
		$this->content.=$this->header();
		$this->content.=$this->blurb();
		$this->content.=$this->table();	
	}	
	
	function Header(){
		echo '<h2>6. Highest Revenues Per Student: 2011</h2>';
	}
	
	function blurb(){
		echo '<p>This page displays the top 5 colleges with the highest revenues per student. This amount was determined by dividing tuition and Fees revenue by the total enrolled students.</p>
		<p>MySQL Query: SELECT universityName, (tuitAndFees / grandTotl) AS sum FROM revFromStudents2011 ORDER BY sum DESC LIMIT 5</p>';
	}	
	
	function table(){
		global $db;
		$revPerStudent = 'SELECT universityName, (tuitAndFees / grandTotl) AS sum FROM revFromStudents2011 ORDER BY sum DESC LIMIT 5';
		echo '<table border="1px"; cellpadding="10">';
		echo '<tr><th>University Name</th><th>Revenue Per Student</th></tr>';
		foreach($db->query($revPerStudent) as $row){
		    echo '<tr><td>';
		    echo $row['universityName'];
		    echo '</td><td>';
		    echo $row['sum'];
		    echo '</td><tr>';
		}
		echo '</table>';
		echo '<br />';
	}
}

// 7. HIGHEST NET ASSETS PER STUDENT
class quest7 extends page {	
	function get(){
		// MENU
		$this->content.=$this->menu();
		$this->content.=$this->header();
		$this->content.=$this->blurb();
		$this->content.=$this->table();	
	}	
	
	function Header(){
		echo '<h2>7. Highest Net Assets Per Student: 2011</h2>';
	}
	
	function blurb(){
		echo '<p>This amount was determined by dividing Net Assets by Total Enrolled Students.</p>
		<p>MySQL Query: SELECT universityName, (totlNetAssts / grandTotl) AS sum FROM topNetAssts ORDER BY sum DESC LIMIT 5';
	}	
	
	function table(){
		global $db;
		$netAssetsPerStudent = 'SELECT universityName, (totlNetAssts / grandTotl) AS sum FROM topNetAssts ORDER BY sum DESC LIMIT 5';
		echo '<table border="1"; cellpadding="10">';
		echo '<tr><th>University Name</th><th>Net Assets Per Student</th></tr>';
		foreach($db->query($netAssetsPerStudent) as $row){
		    echo '<tr><td>';
		    echo $row['universityName'];
		    echo '</td><td>';
		    echo $row['sum'];
		    echo '</td><tr>';
		}
		echo '</table>';
		echo '<br />';
	}
}

// 8. LIABILITIES PER STUDENT
class quest8 extends page {	
	function get(){
		// MENU
		$this->content.=$this->menu();
		$this->content.=$this->header();
		$this->content.=$this->blurb();
		$this->content.=$this->table();	
	}	
	
	function Header(){
		echo '<h2>8. Highest Liabilities Per Student: 2011</h2>';
	}
	
	function blurb(){
		echo '<p>This page displays the top 5 colleges with the highest liabilities per student. This amount was determined by dividing total liabilities by the total enrolled students. The amount of liabilities for just students was not provided, which would provide a more reasonable amount.</p>
		<p>MySQL Command: SELECT universityName, (totlLiabs / grandTotl) AS sum FROM liabPerStud2011 ORDER BY sum DESC LIMIT 5</p>';
	}	
	
	function table(){
		global $db;
		$liabPerStudent = 'SELECT universityName, (totlLiabs / grandTotl) AS sum FROM liabPerStud2011 ORDER BY sum DESC LIMIT 5';
		echo '<table border="1"; cellpadding="10">';
		echo '<tr><th>University Name</th><th>Liabilities Per Student</th></tr>';
		foreach($db->query($liabPerStudent) as $row){
		    echo '<tr><td>';
		    echo $row['universityName'];
		    echo '</td><td>';
		    echo $row['sum'];
		    echo '</td><tr>';
		}
		echo '</table>';
		echo '<br />';
	}
}

// 9. TOP 5 COLLEGES
class quest9 extends page {	
	function get(){
		// MENU
		$this->content.=$this->menu();
		$this->content.=$this->header();
		$this->content.=$this->blurb();
		$this->content.=$this->table();	
	}	
	
	function Header(){
		echo '<h2>9. Top 5 Colleges Based on Above Statistics: 2011</h2>';
	}
	
	function blurb(){
		echo '<p>This page is suppose to display the top 5 colleges based on the above statistics. I might not be able to get to this one, since I\'m still trying to figure this out. My plan is to create a query, store those values in variables and then display those variables in a table.</p>';
	}	
	
	function table(){
		global $db;
	}
}

// 10. FIND COLLEGES BY STATE
class quest10 extends page {	
	function get(){
		// MENU
		$this->content.=$this->menu();
		$this->content.=$this->header();
		$this->content.=$this->blurb();
		$this->content.=$this->formSearch();
	}	
	
	function Header(){
		echo '<h2>10. Find College By State</h2>';
	}
	
	function blurb(){
		echo '<p>Enter a state abbreviation to find colleges within that state. Invalid abbreviations will result in blank search results.</p>';
	}	
	function formSearch(){
		$form = '<form action="index.php?page=answer10" method="post">
            <h3><label for="state"><span>Enter State Abbreviation</span></label><h3>
		    <p><input type="text" name="state" id="state" maxlength="2" value="NJ"/><br />
            <br />
            <input type="submit" value="Send" />
            </p></form>';
		return $form;
    }
}

// 10. DISPLAY RESULTS FROM NUMBER 10
class answer10 extends page {	
	function post(){
		global $db;
		$input = $_POST['state'];
		$states = "SELECT university.universityName, university.state FROM university WHERE university.state='".$input."'";
		echo '<h2>Query Results for '.$input.'</h2>';
		echo '<h4><a href="./index.php"> Home &nbsp; &nbsp; &nbsp; </a><a href="./index.php?page=quest10"> Return to Form</a></h4>';
		echo '<p>Results for your query are displayed below. Click on <a href="./index.php?page=quest10">Return to Form</a> to submit another query.</p> <span>IF YOUR RESULTS ARE BLANK:</span> Please resubmit a valid query.<br /> <br />';
		echo '<table border="1"; cellpadding="10">';
		echo '<tr><th>University Name</th><th>State</th></tr>';
		foreach($db->query($states) as $row){
		    echo '<tr><td>';
		    echo $row['universityName'];
		    echo '</td><td>';
		    echo $row['state'];
		    echo '</td><tr>';
		}
		echo '</table>';
		echo '<br />';
	}	
}

// 11. LARGEST PERCENT INCREASE IN TOTAL LIABILITIES
class quest11 extends page {	
	function get(){
		// MENU
		$this->content.=$this->menu();
		$this->content.=$this->header();
		$this->content.=$this->blurb();
		$this->content.=$this->table();	
	}	
	
	function Header(){
		echo '<h2>11. Largest Percent Increase in Total Liabilities between 2010 and 2011</h2>';
	}
	
	function blurb(){
		echo '<p>This page displays the percent increase in total liabilities between 2010 and 2011. The percent increase is calculated by subtracting the starting value from current value divided by starting value. (Current - Start) / Start.</p>
		<p>MySQL Command: SELECT universityName, ((totlLiabs2011 - totlLiabs2010) / totlLiabs2010) AS sum FROM percLiabilities ORDER BY sum DESC LIMIT 5 </p>';
	}	
	
	function table(){
		global $db;
		$percentLiabilities = 'SELECT universityName, ((totlLiabs2011 - totlLiabs2010) / totlLiabs2010) AS sum FROM percLiabilities ORDER BY sum DESC LIMIT 5';
		echo '<table border="1"; cellpadding="10">';
		echo '<tr><th>University Name</th><th>Percent Increase</th></tr>';
		foreach($db->query($percentLiabilities) as $row){
		    echo '<tr><td>';
		    echo $row['universityName'];
		    echo '</td><td>';
		    echo $row['sum'];
		    echo '</td><tr>';
		}
		echo '</table>';
		echo '<br />';
	}
}

// 12. LARGEST PERCENT INCREASE IN ENROLLMENT
class quest12 extends page {	
	function get(){
		// MENU
		$this->content.=$this->menu();
		$this->content.=$this->header();
		$this->content.=$this->blurb();
		$this->content.=$this->table();	
	}	
	
	function Header(){
		echo '<h2>12. Largest Percent Increase in Enrollment Between 2010 and 2011</h2>';
	}
	
	function blurb(){
		echo '<p>This page displays the top 5 colleges with the greatest percent increase in enrollment. Percent increase is calculated by subtracting the starting value from current value divided by starting value. (Current - Start) / Start.</p>
		<p>MySQL Command: SELECT universityName, ((grandTotl2011 - grandTotl2010) / grandTotl2010) AS sum FROM percEnrollment ORDER BY sum DESC LIMIT 5</p>';
	}	
	
	function table(){
		global $db;
		$percentEnrollment = 'SELECT universityName, ((grandTotl2011 - grandTotl2010) / grandTotl2010) AS sum FROM percEnrollment ORDER BY sum DESC LIMIT 5';
		echo '<table border="1"; cellpadding="10">';
		echo '<tr><th>University Name</th><th>Percent Increase</th></tr>';
		foreach($db->query($percentEnrollment) as $row){
		    echo '<tr><td>';
		    echo $row['universityName'];
		    echo '</td><td>';
		    echo $row['sum'];
		    echo '</td><tr>';
		}
		echo '</table>';
		echo '<br />';
	}
}
?>
