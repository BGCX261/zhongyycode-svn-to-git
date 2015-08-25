<?php
  //We've included ../Includes/FusionCharts_Gen.php, which contains
  //FusionCharts PHP Class to help us easily embed charts 
  //We've also used ../Includes/DBConn.php to easily connect to a database.
  include("../Includes/FusionCharts.php");
  include("../Includes/Connection_inc.php");
?>

<HTML>
   <HEAD>
      <TITLE>
      FusionCharts v3 - Database Example
      </TITLE>
      <?php
         //You need to include the following JS file, if you intend to embed the chart using JavaScript.
         //Embedding using JavaScripts avoids the "Click to Activate..." issue in Internet Explorer
         //When you make your own charts, make sure that the path to this JS file is correct. 
         //Else, you would JavaScript errors.
      ?> 
      <SCRIPT LANGUAGE="Javascript" SRC="../FusionCharts/FusionCharts.js"></SCRIPT>
   </HEAD>
   <BODY>
      <CENTER>
      <?php
         //In this example, we show how to connect FusionCharts to a database.
         //For the sake of ease, we've used an MySQL databases containing two
         //tables.

         // Connect to the Database
         $link = connectToDB();

         # Create pie 3d chart object using FusionCharts PHP Class
         $FC = new FusionCharts("Pie3D","650","450"); 

         # Set Relative Path of chart swf file.
         $FC->setSwfPath("../FusionCharts/");

         #  Define chart attributes 
         $strParam="caption=Factory Output report;subCaption=By Quantity;pieSliceDepth=30; showBorder=1;numberSuffix= Units";

         # Set chart attributes
         $FC->setChartParams($strParam);


         // Fetch all factory records using SQL Query
         // Store chart data values in 'total' column/field and category names in 'FactoryName'  
         $strQuery = "select a.FactoryID, b.FactoryName, sum(a.Quantity) as total from Factory_output a, Factory_Master b where a.FactoryId=b.FactoryId group by a.FactoryId,b.FactoryName";   
         $result = mysql_query($strQuery) or die(mysql_error());

         //Pass the SQL Query result to the FusionCharts PHP Class function
         //along with field/column names that are storing chart values and corresponding category names 
         //to set chart data from database
         if ($result) 
         {
             $FC->addDataFromDatabase($result, "total", "FactoryName");
         }
  
         mysql_close($link);

         # Render the chart
         $FC->renderChart();
      ?>
      </CENTER>
   </BODY>
</HTML>
