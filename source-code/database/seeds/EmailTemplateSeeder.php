<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class EmailTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $emailTemplates = [
            [
                'name' => 'Email Activation',
                'slug' => 'email-activation',
                'tags' => '##ACTIVATION_URL##, ##SITENAME##, ##NAME##, ##SUBJECT##, ##SITEURL##, ##LOGO##',
                'template' =>  '<html xmlns="http://www.w3.org/1999/xhtml">
                               <head>
                                  <meta http-equiv="content-type" content="text/html; charset=utf-8">
                                  <meta name="viewport" content="width=device-width, initial-scale=1.0;">
                                  <meta name="format-detection" content="telephone=no"/>
                                  <meta http-equiv="content-type" content="text/html; charset=utf-8">
                                  <style>
                                     body { margin: 0; padding: 0; min-width: 100%; width: 100% !important; height: 100% !important;}
                                     body, table, td, div, p, a { -webkit-font-smoothing: antialiased; text-size-adjust: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; line-height: 100%; }
                                     table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-collapse: collapse !important; border-spacing: 0; }
                                     img { border: 0; line-height: 100%; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; }
                                     #outlook a { padding: 0; }
                                     .ReadMsgBody { width: 100%; } .ExternalClass { width: 100%; }
                                     .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div { line-height: 100%; }
                                     @media all and (min-width: 560px) {
                                     .container { border-radius: 8px; -webkit-border-radius: 8px; -moz-border-radius: 8px; -khtml-border-radius: 8px;}
                                     }
                                     a, a:hover {
                                     color: #127DB3;
                                     }
                                     .footer a, .footer a:hover {
                                     color: #999999;
                                     }
                                  </style>
                               </head>
                               <body topmargin="0" rightmargin="0" bottommargin="0" leftmargin="0" marginwidth="0" marginheight="0" width="100%" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; width: 100%; height: 100%; -webkit-font-smoothing: antialiased; text-size-adjust: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; line-height: 100%;
                                  background-color: #F0F0F0;
                                  color: #000000;"
                                  bgcolor="#F0F0F0"
                                  text="#000000">
                                  <title>##SUBJECT##</title>
                                  <p></p>
                                  <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; width: 100%;" class="background">
                                     <tbody>
                                        <tr>
                                           <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0;" bgcolor="#F0F0F0">
                                              <table border="0" cellpadding="0" cellspacing="0" align="center" width="560" style="border-collapse: collapse; border-spacing: 0; padding: 0; width: inherit;
                                                 max-width: 560px;" class="wrapper">
                                                 <tbody>
                                                    <tr>
                                                       <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%;
                                                          padding-top: 20px;
                                                          padding-bottom: 20px;">
                                                          <a target="_blank" style="text-decoration: none;" href="##SITEURL##"><img border="0" vspace="0" hspace="0" src="##LOGO##" width="100" height="30" alt="Logo" title="Logo" style="
                                                             color: #000000;
                                                             font-size: 10px; margin: 0; padding: 0; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; border: none; display: block;"></a>
                                                       </td>
                                                    </tr>
                                                 </tbody>
                                              </table>
                                              <table border="0" cellpadding="0" cellspacing="0" align="center" bgcolor="#FFFFFF" width="560" style="border-collapse: collapse; border-spacing: 0; padding: 0; width: inherit;
                                                 max-width: 560px;" class="container">
                                                 <tbody>
                                                    <tr>
                                                       <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0px; margin: 0px; padding: 25px 6.25% 0px; width: 87.5%; font-size: 16px; line-height: 130%; color: rgb(0, 0, 0); font-family: sans-serif;" class="header">
                                                          <p style="font-weight: bold;">
                                                          </p>
                                                          <p style="text-align: left;">Dear ##NAME##,</p>
                                                       </td>
                                                    </tr>
                                                    <tr>
                                                       <td align="left" valign="top" style="border-collapse: collapse; border-spacing: 0px; margin: 0px; padding: 25px 6.25% 0px; width: 87.5%; font-size: 16px; line-height: 130%; color: rgb(0, 0, 0); font-family: sans-serif;" class="subheader">
                                                          <p>Welcome to ##SITENAME##.  ##SITENAME## is a marketplace to sell, buy and customise source codes, scripts, themes, plugins and more powered by git.</p>
                                                       </td>
                                                    </tr>
                                                    <tr>
                                                       <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%; font-size: 17px; font-weight: 400; line-height: 130%;
                                                          padding-top: 25px; 
                                                          color: #000000;
                                                          font-family: sans-serif;" class="paragraph">
                                                          Please click the below link to complete your registration and to activate your account.
                                                       </td>
                                                    </tr>
                                                    <tr>
                                                       <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%;
                                                          padding-top: 25px;
                                                          padding-bottom: 5px;" class="button">
                                                          <table border="0" cellpadding="0" cellspacing="0" align="center" style="text-decoration: underline; max-width: 240px; min-width: 120px; border-collapse: collapse; border-spacing: 0px; padding: 0px;">
                                                             <tbody>
                                                                <tr>
                                                                   <td align="center" valign="middle" style="padding: 12px 8px; margin: 0; text-decoration: underline; border-collapse: collapse; border-spacing: 0; border-radius: 4px; -webkit-border-radius: 4px; -moz-border-radius: 4px; -khtml-border-radius: 4px;" bgcolor="#094f78">
                                                                      <p>
                                                                         <span style="color: #ffffff;"><a href="##ACTIVATION_URL##" style="color:#ffffff" target="_blank">Activate Account</a>
                                                                         </span>
                                                                      </p>
                                                                   </td>
                                                                </tr>
                                                             </tbody>
                                                          </table>
                                                       </td>
                                                    </tr>
                                                    <tr>
                                                       <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%;
                                                          padding-top: 25px;" class="line">
                                                          <hr color="#E0E0E0" align="center" width="100%" size="1" noshade="" style="margin: 0; padding: 0;">
                                                       </td>
                                                    </tr>
                                                    <tr>
                                                       <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%; font-size: 17px; font-weight: 400; line-height: 160%;
                                                          padding-top: 20px;
                                                          padding-bottom: 25px;
                                                          color: #000000;
                                                          font-family: sans-serif;" class="paragraph">
                                                          <p>
                                                             Have a question? <a href="mailto:test@test.com" target="_blank">test@test.com</a>
                                                          </p>
                                                       </td>
                                                    </tr>
                                                 </tbody>
                                              </table>
                                              <table border="0" cellpadding="0" cellspacing="0" align="center" width="560" style="border-collapse: collapse; border-spacing: 0; padding: 0; width: inherit;
                                                 max-width: 560px;" class="wrapper">
                                                 <tbody>
                                                    <tr>
                                                       <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%;
                                                          padding-top: 25px;" class="social-icons">
                                                       </td>
                                                    </tr>
                                                    <tr>
                                                       <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%; font-size: 13px; font-weight: 400; line-height: 150%;
                                                          padding-top: 20px;
                                                          padding-bottom: 20px;
                                                          color: #999999;
                                                          font-family: sans-serif;" class="footer">
                                                          copyrights © ##SITENAME##.                        
                                                       </td>
                                                    </tr>
                                                 </tbody>
                                              </table>
                                           </td>
                                        </tr>
                                     </tbody>
                                  </table>
                               </body>
                            </html>',
                'subject' => 'Account activation - ##SITENAME##',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Reset Password Email',
                'slug' => 'reset-password-email',
                'tags' => '##RESET_URL##, ##SITENAME##, ##NAME##, ##SUBJECT##, ##SITEURL##, ##LOGO##',
                'template' => '<html xmlns="http://www.w3.org/1999/xhtml">
                           <head>
                              <meta http-equiv="content-type" content="text/html; charset=utf-8">
                              <meta name="viewport" content="width=device-width, initial-scale=1.0;">
                              <meta name="format-detection" content="telephone=no"/>
                              <style>
                                 body { margin: 0; padding: 0; min-width: 100%; width: 100% !important; height: 100% !important;}
                                 body, table, td, div, p, a { -webkit-font-smoothing: antialiased; text-size-adjust: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; line-height: 100%; }
                                 table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-collapse: collapse !important; border-spacing: 0; }
                                 img { border: 0; line-height: 100%; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; }
                                 #outlook a { padding: 0; }
                                 .ReadMsgBody { width: 100%; } .ExternalClass { width: 100%; }
                                 .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div { line-height: 100%; }
                                 @media all and (min-width: 560px) {
                                 .container { border-radius: 8px; -webkit-border-radius: 8px; -moz-border-radius: 8px; -khtml-border-radius: 8px;}
                                 }
                                 a, a:hover {
                                 color: #127DB3;
                                 }
                                 .footer a, .footer a:hover {
                                 color: #999999;
                                 }
                              </style>
                              <title>##SUBJECT##</title>
                           </head>
                           <body topmargin="0" rightmargin="0" bottommargin="0" leftmargin="0" marginwidth="0" marginheight="0" width="100%" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; width: 100%; height: 100%; -webkit-font-smoothing: antialiased; text-size-adjust: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; line-height: 100%;
                              background-color: #F0F0F0;
                              color: #000000;"
                              bgcolor="#F0F0F0"
                              text="#000000">
                              <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; width: 100%;" class="background">
                                 <tbody>
                                    <tr>
                                       <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0;" bgcolor="#F0F0F0">
                                          <table border="0" cellpadding="0" cellspacing="0" align="center" width="560" style="border-collapse: collapse; border-spacing: 0; padding: 0; width: inherit;
                                             max-width: 560px;" class="wrapper">
                                             <tbody>
                                                <tr>
                                                   <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%;
                                                      padding-top: 20px;
                                                      padding-bottom: 20px;">
                                                      <a target="_blank" style="text-decoration: none;" href="##SITEURL##"><img border="0" vspace="0" hspace="0" src="##LOGO##" width="100" height="30" alt="Logo" title="Logo" style="
                                                         color: #000000;
                                                         font-size: 10px; margin: 0; padding: 0; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; border: none; display: block;"></a>
                                                   </td>
                                                </tr>
                                             </tbody>
                                          </table>
                                          <table border="0" cellpadding="0" cellspacing="0" align="center" bgcolor="#FFFFFF" width="560" style="border-collapse: collapse; border-spacing: 0; padding: 0; width: inherit;
                                             max-width: 560px;" class="container">
                                             <tbody>
                                                <tr>
                                                   <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0px; margin: 0px; padding: 25px 6.25% 0px; width: 87.5%; font-size: 16px; line-height: 130%; color: rgb(0, 0, 0); font-family: sans-serif;" class="header">
                                                      <p style="font-weight: bold;">
                                                      </p>
                                                      <p style="text-align: left;">Dear ##NAME##,</p>
                                                   </td>
                                                </tr>
                                                <tr>
                                                   <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-bottom: 3px; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%; font-size: 18px; font-weight: 300; line-height: 150%;
                                                      padding-top: 5px;
                                                      color: #000000;
                                                      font-family: sans-serif;" class="subheader">
                                                      <p style="text-align: left;">You are receiving this email because we received a password reset request for your account.&nbsp;</p>
                                                   </td>
                                                </tr>
                                                <tr>
                                                   <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%;
                                                      padding-top: 25px;
                                                      padding-bottom: 5px;" class="button">
                                                      <table border="0" cellpadding="0" cellspacing="0" align="center" style="text-decoration: underline; max-width: 240px; min-width: 120px; border-collapse: collapse; border-spacing: 0px; padding: 0px;">
                                                         <tbody>
                                                            <tr>
                                                               <td align="center" valign="middle" style="padding: 12px 8px; margin: 0; text-decoration: underline; border-collapse: collapse; border-spacing: 0; border-radius: 4px; -webkit-border-radius: 4px; -moz-border-radius: 4px; -khtml-border-radius: 4px;" bgcolor="#094f78">
                                                                  <p>
                                                                     <span style="color: #ffffff;"><a href="##RESET_URL##" style="color:#ffffff" target="_blank">Reset Password</a>
                                                                     </span>
                                                                  </p>
                                                               </td>
                                                            </tr>
                                                         </tbody>
                                                      </table>
                                                   </td>
                                                </tr>
                                                <tr>
                                                   <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%;
                                                      padding-top: 25px;" class="line">If you did not request a password reset, no further action is required.<br></td>
                                                </tr>
                                                <tr>
                                                   <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%;
                                                      padding-top: 25px;" class="line">
                                                      <hr color="#E0E0E0" align="center" width="100%" size="1" noshade="" style="margin: 0; padding: 0;">
                                                   </td>
                                                </tr>
                                                <tr>
                                                   <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%; font-size: 17px; font-weight: 400; line-height: 160%;
                                                      padding-top: 20px;
                                                      padding-bottom: 25px;
                                                      color: #000000;
                                                      font-family: sans-serif;" class="paragraph">
                                                      <p>
                                                         Have a&nbsp;question? <a href="mailto:test@test.com" target="_blank">test@test.com</a>
                                                      </p>
                                                   </td>
                                                </tr>
                                             </tbody>
                                          </table>
                                          <table border="0" cellpadding="0" cellspacing="0" align="center" width="560" style="border-collapse: collapse; border-spacing: 0; padding: 0; width: inherit;
                                             max-width: 560px;" class="wrapper">
                                             <tbody>
                                                <tr>
                                                   <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%;
                                                      padding-top: 25px;" class="social-icons">
                                                   </td>
                                                </tr>
                                                <tr>
                                                   <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%; font-size: 13px; font-weight: 400; line-height: 150%;
                                                      padding-top: 20px;
                                                      padding-bottom: 20px;
                                                      color: #999999;
                                                      font-family: sans-serif;" class="footer">
                                                      copyrights © ##SITENAME##.                        
                                                   </td>
                                                </tr>
                                             </tbody>
                                          </table>
                                       </td>
                                    </tr>
                                 </tbody>
                              </table>
                           </body>
                        </html>',
                'subject' => 'Reset Password - ##SITENAME##',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
    	];

        DB::table('email_templates')->insert($emailTemplates);
    }
}
