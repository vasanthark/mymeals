{{-- resources/views/emails/password.blade.php --}}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>MyMeals</title>
        <style>
            /**********************************************
            * Ink v1.0.5 - Copyright 2013 ZURB Inc        *
            **********************************************/

            /* Client-specific Styles & Reset */

            #outlook a { 
                padding:0; 
            } 

            body{ 
                width:100% !important; 
                min-width: 100%;
                -webkit-text-size-adjust:100%; 
                -ms-text-size-adjust:100%; 
                margin:0; 
                padding:0;
            }


            #backgroundTable { 
                margin:0; 
                padding:0; 
                width:100% !important; 
                line-height: 100% !important; 
            }

            img { 
                outline:none; 
                text-decoration:none; 
                -ms-interpolation-mode: bicubic;
                width: auto;
                max-width: 100%; 
                float: left; 
                clear: both; 
                display: block;
            }

            center {
                width: 100%;
                min-width: 580px;
            }

            a img { 
                border: none;
            }

            p {
                margin: 0 0 0 10px;
            }

            table {
                border-spacing: 0;
                border-collapse: collapse;
            }

            td { 
                word-break: break-word;
                -webkit-hyphens: auto;
                -moz-hyphens: auto;
                hyphens: auto;
                border-collapse: collapse !important; 
            }

            table, tr, td {
                padding: 0;
                vertical-align: top;
                text-align: left;
            }

            hr {
                color: #d9d9d9; 
                background-color: #d9d9d9; 
                height: 1px; 
                border: none;
            }

            /* Responsive Grid */

            table.body {
                height: 100%;
                width: 100%;
            }

            table.container {
                width: 580px;
                margin: 0 auto;
                text-align: inherit;
            }

            /* Typography */

            body, table.body, h1, h2, h3, h4, h5, h6, p, td { 
                color: #222222;
                font-family:'Helvetica Neue',Arial,sans-serif;
                font-weight: normal; 
                padding:0; 
                margin: 0;
                text-align: left; 
                line-height: 1.3;
            }

            h1, h2, h3, h4, h5, h6 {
                word-break: normal;
            }

            h1 {font-size: 40px;}
            h2 {font-size: 36px;}
            h3 {font-size: 32px;}
            h4 {font-size: 28px;}
            h5 {font-size: 24px;}
            h6 {font-size: 20px;}
            body, table.body, p, td {font-size: 14px;line-height:19px;}

            p.lead, p.lede, p.leed {
                font-size: 18px;
                line-height:21px;
            }

            p { 
                margin-bottom: 10px;
            }

            small {
                font-size: 10px;
            }

            a {
                color: #2ba6cb; 
                text-decoration: none;
            }

            a:hover { 
                color: #2795b6 !important;
            }

            a:active { 
                color: #2795b6 !important;
            }

            a:visited { 
                color: #2ba6cb !important;
            }

            h1 a, 
            h2 a, 
            h3 a, 
            h4 a, 
            h5 a, 
            h6 a {
                color: #2ba6cb;
            }

            h1 a:active, 
            h2 a:active,  
            h3 a:active, 
            h4 a:active, 
            h5 a:active, 
            h6 a:active { 
                color: #2ba6cb !important; 
            } 

            h1 a:visited, 
            h2 a:visited,  
            h3 a:visited, 
            h4 a:visited, 
            h5 a:visited, 
            h6 a:visited { 
                color: #2ba6cb !important; 
            } 

        </style>
    </head>
    <body class="body">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="container" style="border:#52616E 1px solid; border-radius:2px; border-collapse:separate; border-spacing:0; margin-top:20px;">
            <tr>
                <td>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color:#52616E;">
                        <tr>
                            <td align="center"  style=" padding:10px;"> My Meals</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td  style="padding:20px 20px 0 20px">
                                <p style="color: #545454; font-size: 13px; line-height: 20px;">Hi,</p>
                                <p style="color: #545454; font-size: 13px; line-height: 20px;">Click the "Reset Password" link to reset your password. <a href="{{ url('password/reset/'.$token) }}">Reset Password</a></p>
                                <p style="color: #545454; font-size: 13px; line-height: 20px;">If you can't click the button above, you can copying and pasting (or typing) the following address into your browser:</p>
                                <p style="color: #545454; font-size: 13px; line-height: 20px;">{{ url('password/reset/'.$token) }}</p>
                            </td>
                        </tr>
                        <td  style="padding:20px 20px 10px;"> 
                            <p  style="color: #545454; font-size: 13px; line-height: 20px;">Thank you,<br />My Meals Team</p>
                        </td>
                    </table>
                </td>
            </tr>

        </table>           
    </body>
</html>