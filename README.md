# moeSS
Moe SS
Moe SS id a front end for https://github.com/mengskysama/shadowsocks/tree/manyuser

Thanks to ss-panal https://github.com/orvice/ss-panel

Demo: https://ss.qaq.moe

# Install
- Import shadowsocks.sql to your database. **May delete your existing data!**
- Rename config-sample.php and database-sample.php in application/config/, then change the settings.
- Use admin/admin to login the admin dashboard, and change settings in http://your.domain.com/admin/system_config.html
- To prevent spam register, users need to click a link to activate the account. So you need to set a method to send e-mail.
Currently supprt php mail(), sendmail, SMTP and SendGrid Web API. (Send test E-mail function will be added soon)

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

# License
See [LICENSE](https://github.com/wzxjohn/moeSS/blob/master/LICENSE)

# Requires
- This system is using [CodeIgniter 3.0](https://github.com/bcit-ci/CodeIgniter) to build, so you need php, mysql, curl to run.
- Apache is the best one because it support *.htaccess* file, which is needed to rewrite the request uri to index.php.
