<?php
namespace App\Providers; use App\System; use Illuminate\Support\Facades\DB; use Illuminate\Support\Facades\Schema; use Illuminate\Support\ServiceProvider; class ConfigServiceProvider extends ServiceProvider { public function boot() { try { config()->set(array('app.project' => 'card_free', 'app.version' => '2.93', 'app.name' => System::_get('app_name'), 'app.title' => System::_get('app_title'), 'app.url' => System::_get('app_url'), 'app.url_api' => System::_get('app_url_api'), 'app.logo' => System::_get('logo'), 'app.description' => System::_get('description'), 'app.keywords' => System::_get('keywords'), 'app.company' => System::_get('company'), 'app.icp' => System::_get('icp'), 'services.geetest.id' => System::_get('vcode_geetest_id'), 'services.geetest.key' => System::_get('vcode_geetest_key'), 'mail.driver' => System::_get('mail_driver'), 'mail.host' => System::_get('mail_smtp_host'), 'mail.port' => System::_get('mail_smtp_port'), 'mail.username' => System::_get('mail_smtp_username'), 'mail.password' => System::_get('mail_smtp_password'), 'mail.from.address' => System::_get('mail_smtp_from_address'), 'mail.from.name' => System::_get('mail_smtp_from_name'), 'mail.encryption' => System::_get('mail_smtp_encryption') === 'null' ? null : System::_get('mail_smtp_encryption'), 'services.sendcloud.api_user' => System::_get('sendcloud_user'), 'services.sendcloud.api_key' => System::_get('sendcloud_key'), 'filesystems.default' => System::_get('storage_driver'), 'filesystems.disks.s3.key' => System::_get('storage_s3_access_key'), 'filesystems.disks.s3.secret' => System::_get('storage_s3_secret_key'), 'filesystems.disks.s3.region' => System::_get('storage_s3_region'), 'filesystems.disks.s3.bucket' => System::_get('storage_s3_bucket'), 'filesystems.disks.oss.access_id' => System::_get('storage_oss_access_key'), 'filesystems.disks.oss.access_key' => System::_get('storage_oss_secret_key'), 'filesystems.disks.oss.bucket' => System::_get('storage_oss_bucket'), 'filesystems.disks.oss.endpoint' => System::_get('storage_oss_endpoint'), 'filesystems.disks.oss.cdnDomain' => System::_get('storage_oss_cdn_domain'), 'filesystems.disks.oss.ssl' => (int) System::_get('storage_oss_is_ssl') === 1, 'filesystems.disks.oss.isCName' => (int) System::_get('storage_oss_is_cname') === 1, 'filesystems.disks.qiniu.access_key' => System::_get('storage_qiniu_access_key'), 'filesystems.disks.qiniu.secret_key' => System::_get('storage_qiniu_secret_key'), 'filesystems.disks.qiniu.bucket' => System::_get('storage_qiniu_bucket'), 'filesystems.disks.qiniu.domains.default' => System::_get('storage_qiniu_domains_default'), 'filesystems.disks.qiniu.domains.https' => System::_get('storage_qiniu_domains_https'))); } catch (\Exception $sp8e3e91) { \Log::error('Config init failed: ' . $sp8e3e91->getMessage(), array('exception' => $sp8e3e91)); } } public function register() { } }