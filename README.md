# moeSS
moeSS is a front end for https://github.com/mengskysama/shadowsocks/tree/manyuser

Thanks to ss-panel https://github.com/orvice/ss-panel

Demo: https://ss.qaq.moe

# Install
- [中文安装说明](https://www.evernote.com/shard/s42/sh/7a30525d-a949-4132-9916-1f4fbdbf4828/6eca7d1ce520e173b1a5ebf9489a766d)
- [Wiki](https://github.com/wzxjohn/moeSS/wiki)
- Import shadowsocks.sql to your database. **May delete your existing data!**
- Rename config-sample.php and database-sample.php in application/config/, then change the settings.
- Use admin/admin12345 to login the admin dashboard, and change settings in http://your.domain.com/admin/system_config.html
- To prevent spam register, users need to click a link to activate the account. So you need to set a method to send e-mail.
Currently support php mail(), sendmail, SMTP and SendGrid Web API. (Send test E-mail function will be added soon)

| Method     | option_value |
| ---------- | ------------ |
| php mail() |     mail     |
| sendmail   |   sendmail   |
| SMTP       |     smtp     |
| SendGrid   |   sendgrid   |

**Only change this is not enough. You also need to change other values need by the method you choose.**
- Invite only is default on. You need to generate invite code before anyone can registe.
- Because I don't use any encrypt function when post the data, you are suggesting to secure your site by using SSL certs.
- Many notices and sentences are **written directly in the view files**, so you need to **edit the file** to change them. They may moved to database in the future.

# Upgrade
If database structure has been changed after update, I will upload a sql file in update folder. Just use that sql file to update database structures.

# License
The license under which the moeSS is released is the GPLv3 (or later) from the Free Software Foundation.
A copy of the license is included with every copy of moeSS,
but you can also read the text of the license [here](https://github.com/wzxjohn/moeSS/blob/master/LICENSE).
In addition, I request anyone who uses this software do not change the CopyRight information.

# Requires
- This system is using [CodeIgniter 3.0](https://github.com/bcit-ci/CodeIgniter) to build, so you need PHP 5.4 or newer, MySQL (5.1+), curl to run.
- Apache is the best one because it support *.htaccess* file, which is needed to rewrite the request uri to index.php.
