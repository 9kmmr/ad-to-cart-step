<?php
    $mysqli = new \mysqli("localhost", "xpress_deepbratt", "Samadder5#", "xpress_delivery");		

	if ($mysqli->connect_errno) {
		echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}
    $sql = "SELECT * FROM orders WHERE id=42";   
    $results =  mysqli_fetch_assoc(mysqli_query($mysqli,$sql));

    $content = '
    <div style="max-width:650;width:100%;display:inline-flex">
        <div style="margin:5px;width:50%;float:left;">
            <label for="">Name:<span style="float:right;">'.urldecode($results["fullname"]).' </span></label><br />
            <label for="">From:<span style="float:right;">'.urldecode($results["from"]).'</span></label><br />
            <label for="">Package:<span style="float:right;">'.urldecode($results["package"]).'</span></label><br />
            <label for="">Distance:<span style="float:right;">'.urldecode($results["distant"]).'</span></label><br />
        </div>
        <div style="margin:5px;width:50%;float:right;">
            <label for="">Billing Address:<span style="float:right;">'.urldecode($results["address"]).'</span></label><br />
            <label for="">To:<span style="float:right;">'.urldecode($results["to"]).'</span></label><br />
            <label for="">Date:<span style="float:right;">'.urldecode($results["dtime"]).'</span></label><br />
            <label for="">Cost:<span style="float:right;"> £'.urldecode($results["money"]).'</span></label><br />
        </div>
    </div>
    
    ';
    
    $message = '<html>
                <head>
                <meta charset="utf-8">
                <title>Admin Confirmation Of Booking</title>
                </head>
                <body>
                <table width="650" border="1" align="center" cellpadding="0" cellspacing="0">
                <tr>
                    <td><table width="650" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td align="center"><img src="http://firminxpress.com/email/admin1.jpg" width="650" height="221"  alt="head"/></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td><table width="610" border="0" align="center" cellpadding="0" cellspacing="0">
                        <tr>
                            <td style="font-family: Arial, "Gill Sans", "Gill Sans MT", "Myriad Pro", "DejaVu Sans Condensed", Helvetica, sans-serif"> 
                                '.$content.'                          
                            </td>
                        </tr>
                        </table></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="center"><img src="http://firminxpress.com/email/admin2.jpg" width="650" height="164"  alt="foot"/></td>
                    </tr>
                    </table></td>
                </tr>
                </table>
                </body>
                </html>';
    
    $to = "aushet4@gmail.com";
	$subject = "Admin Confirmation Of Booking";
	
	$headers = "From: xpress@firminxpress.info" . "\r\n";

	$headers .= "Content-Type: text/html;charset=iso-8859-1\r\n";
	$headers  .= 'MIME-Version: 1.0' . "\r\n";
	mail($to,$subject,$message,$headers);

?>
