<!DOCTYPE html>
<html lang="en">
<head>
    <title>Salted | A Responsive Email Template</title>
    <!--

        SALTED | A RESPONSIVE EMAIL TEMPLATE
        =====================================

        Based on code used and tested by Litmus (@litmusapp)
        Originally developed by Kevin Mandeville (@KEVINgotbounce)
        Cleaned up by Jason Rodriguez (@rodriguezcommaj)
        Presented by A List Apart (@alistapart)

        Email is surprisingly hard. While this has been thoroughly tested, your mileage may vary.
        It's highly recommended that you test using a service like Litmus and your own devices.

        Enjoy!

     -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <style type="text/css">
        /* CLIENT-SPECIFIC STYLES */
        #outlook a{padding:0;} /* Force Outlook to provide a "view in browser" message */
        .ReadMsgBody{width:100%;} .ExternalClass{width:100%;} /* Force Hotmail to display emails at full width */
        .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height: 100%;} /* Force Hotmail to display normal line spacing */
        body, table, td, a{-webkit-text-size-adjust:100%; -ms-text-size-adjust:100%;} /* Prevent WebKit and Windows mobile changing default text sizes */
        table, td{mso-table-lspace:0pt; mso-table-rspace:0pt;} /* Remove spacing between tables in Outlook 2007 and up */
        img{-ms-interpolation-mode:bicubic;} /* Allow smoother rendering of resized image in Internet Explorer */

        /* RESET STYLES */
        body{margin:0; padding:0;}
        img{border:0; height:auto; line-height:100%; outline:none; text-decoration:none;}
        table{border-collapse:collapse !important;}
        body{height:100% !important; margin:0; padding:0; width:100% !important;}

        /* iOS BLUE LINKS */
        .appleBody a {color:#68440a; text-decoration: none;}
        .appleFooter a {color:#999999; text-decoration: none;}

        /* MOBILE STYLES */
        @media screen and (max-width: 525px) {

            /* ALLOWS FOR FLUID TABLES */
            table[class="wrapper"]{
                width:100% !important;
            }

            /* ADJUSTS LAYOUT OF LOGO IMAGE */
            td[class="logo"]{
                text-align: left;
                padding: 20px 0 20px 0 !important;
            }

            td[class="logo"] img{
                margin:0 auto!important;
            }

            /* USE THESE CLASSES TO HIDE CONTENT ON MOBILE */
            td[class="mobile-hide"]{
                display:none;}

            img[class="mobile-hide"]{
                display: none !important;
            }

            img[class="img-max"]{
                max-width: 100% !important;
                height:auto !important;
            }

            /* FULL-WIDTH TABLES */
            table[class="responsive-table"]{
                width:100%!important;
            }

            /* UTILITY CLASSES FOR ADJUSTING PADDING ON MOBILE */
            td[class="padding"]{
                padding: 10px 5% 15px 5% !important;
            }

            td[class="padding-copy"]{
                padding: 10px 5% 10px 5% !important;
                text-align: center;
            }

            td[class="padding-meta"]{
                padding: 30px 5% 0px 5% !important;
                text-align: center;
            }

            td[class="no-pad"]{
                padding: 0 0 20px 0 !important;
            }

            td[class="no-padding"]{
                padding: 0 !important;
            }

            td[class="section-padding"]{
                padding: 50px 15px 50px 15px !important;
            }

            td[class="section-padding-bottom-image"]{
                padding: 50px 15px 0 15px !important;
            }

            /* ADJUST BUTTONS ON MOBILE */
            td[class="mobile-wrapper"]{
                padding: 10px 5% 15px 5% !important;
            }

            table[class="mobile-button-container"]{
                margin:0 auto;
                width:100% !important;
            }

            a[class="mobile-button"]{
                width:80% !important;
                padding: 15px !important;
                border: 0 !important;
                font-size: 16px !important;
            }

        }
    </style>
</head>
<body style="margin: 0; padding: 0;">

<!-- COMPACT ARTICLE SECTION -->
<table border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;">
    <tr>
        <td bgcolor="#f8f8f8" align="center" style="padding: 70px 15px 70px 15px;" class="section-padding">
            <table border="0" cellpadding="0" cellspacing="0" width="500" style="padding:0 0 20px 0;" class="responsive-table">
                <!-- TITLE -->
                <tr>
                    <td valign="top" style="padding: 40px 0 0 0;" class="mobile-hide"><a href="http://www.portcotonou.com/" target="_blank"><img src="{{env('APP_URL')}}/assets/images/logo.png" alt="Port Autonome de Cotonou" width="105" height="105" border="0" style="display: block; font-family: Arial; color: #666666; font-size: 14px; width: 105px; height: 105px;"></a></td>
                    <td style="padding: 40px 0 0 0;" class="no-padding">
                        <!-- ARTICLE -->
                        <table border="0" cellspacing="0" cellpadding="0" width="100%">
                            <tr>
                                <td align="left" style="padding: 0 0 5px 25px; font-size: 13px; font-family: Helvetica, Arial, sans-serif; font-weight: normal; color: #aaaaaa;" class="padding-meta">Port autonome de Cotonou</td>
                            </tr>
                            <tr>
                                <td align="left" style="padding: 0 0 5px 25px; font-size: 22px; font-family: Helvetica, Arial, sans-serif; font-weight: normal; color: #333333;" class="padding-copy">Verification d'email</td>
                            </tr>
                            <tr>
                                <td align="left" style="padding: 10px 0 15px 25px; font-size: 16px; line-height: 24px; font-family: Helvetica, Arial, sans-serif; color: #666666;" class="padding-copy">Salut {{$name}}! Vous avez été enregistré sur la plateforme Acces piétons du Port Autonome de Cotonou. Votre jeton de vérification est : {{$verification_code}}. Votre mot de passe: {{$password}}.
                                Pour plus de sécurité, pensez à changer ce mot de passe une fois que vous serez connecté.
                                </td>
                            </tr>
                            <tr>
                                <td style="padding:0 0 45px 25px;" align="left" class="padding">
                                    <table border="0" cellspacing="0" cellpadding="0" class="mobile-button-container">
                                        <tr>
                                            <td align="center">
                                                <!-- BULLETPROOF BUTTON -->
                                                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="mobile-button-container">
                                                    <tr>
                                                        <td align="center" style="padding: 0;" class="padding-copy">
                                                            <table border="0" cellspacing="0" cellpadding="0" class="responsive-table">
                                                                <tr>
                                                                    <td align="center"><a href={{env('APP_URL').'/api'.'/verify_email/'.$uid.'/'.$verification_code}} target="_blank" style="font-size: 15px; font-family: Helvetica, Arial, sans-serif; font-weight: normal; color: #ffffff; text-decoration: none; background-color: #4FC1E9; border-top: 10px solid #4FC1E9; border-bottom: 10px solid #4FC1E9; border-left: 20px solid #4FC1E9; border-right: 20px solid #4FC1E9; border-radius: 3px; -webkit-border-radius: 3px; -moz-border-radius: 3px; display: inline-block;" class="mobile-button">Vérifier email &rarr;</a></td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<!-- FOOTER -->
<table border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;">
    <tr>
        <td bgcolor="#ffffff" align="center">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                <tr>
                    <td style="padding: 20px 0px 20px 0px;">
                        <!-- UNSUBSCRIBE COPY -->
                        <table width="500" border="0" cellspacing="0" cellpadding="0" align="center" class="responsive-table">
                            <tr>
                                <td align="center" valign="middle" style="font-size: 12px; line-height: 18px; font-family: Helvetica, Arial, sans-serif; color:#666666;">
                                    <span class="appleFooter" style="color:#666666;">Port Autonome de Cotonou - Boulevard de la Marina - BP 927 Cotonou – Bénin</span><br><a class="original-only" style="color: #666666; text-decoration: none;">(+229) 21 31 26 37</a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

</body>
</html>