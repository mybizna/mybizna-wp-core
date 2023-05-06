<?php

/**
 * Mybizna Core
 *
 * @package           Mybizna
 * @author            Dedan Irungu
 * @copyright         2022 Mybizna.com
 * @license           GPL-3.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       Mybizna
 * Plugin URI:        https://wordpress.org/plugins/mybizna-core/
 * Description:       This is the base plugin for implementing a erp level intragration into wordpress and allow any post to be sellable.
 * Version:           1.0.0
 * Requires at least: 5.4
 * Requires PHP:      7.2
 * Author:            Dedan Irungu
 * Author URI:        https://mybizna.com
 * Text Domain:       mybizna-core
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

// Changes to css
function mybizna_load_plugin_css()
{
    $plugin_url = plugin_dir_url(__FILE__);

    wp_enqueue_style('mybizna_style1', $plugin_url . 'assets/css/style.css');
}
add_action('admin_enqueue_scripts', 'mybizna_load_plugin_css');

/**
 *
 *
 *
 *
 */
// Changes to 404

function mybizna_do_stuff_on_404()
{
    if (is_404()) {
        $protocol = is_ssl() ? 'https://' : 'http://';
        $current_url = ($protocol) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

        $options = get_option('mybizna_setting');

        $is_api = str_contains($current_url, 'api/');
        $is_component = str_contains($current_url, 'components/');
        $is_fetch_vue = str_contains($current_url, 'fetch_vue/');
        $is_manage = str_contains($current_url, '/manage');

        if (!$is_api && !$is_component && !$is_fetch_vue && !$is_manage) {
            get_header();
        }

        $url = str_replace(site_url(), '', $current_url);

        if ($is_manage) {

            if (!is_user_logged_in()) {
                wp_redirect(wp_login_url());
            }

            if (!current_user_can('manage_options')) {
                $title = 'Access Denied.';
                $message = '<b class="text-md">Access Denied:</b> Your user account does have right to access <b>"/manage"</b> on frontend.';
                for_404_html_page($title, $message);
                exit;
            }

            if (!isset($options['frontend_manage'])) {
                $title = 'Accessing Frontend is Disabled.';
                $message = 'Accessing <b>"/manage"</b> on Frontend is Disabled.';
                for_404_html_page($title, $message);
                exit;
            }
        }

        mybizna_contents($url, true, 768);

        if (!$is_api && !$is_component && !$is_fetch_vue && !$is_manage) {
            if (function_exists('getfooter')) {
                getfooter();
            }
        }

        exit;

    }
}
add_action('template_redirect', 'mybizna_do_stuff_on_404');

/**
 *
 *
 *
 *
 */

function mybizna_setting_render_plugin_settings_page()
{
    $assets_url = plugins_url() . '/mybizna/mybizna/public/mybizna';
    ?>
<main>
  <div class="container py-4">

    <header class="pb-3 mb-4 border-bottom">
      <a href="/" class="d-flex align-items-center text-dark text-decoration-none">
        <svg xmlns="http://www.w3.org/2000/svg" class="icon" height="40" viewBox="0 0 1024 1024" version="1.1"><path d="M397.415 528.307h-108.76V387.336h105.807v28.971h-75.004v24.91h70.246v28.889h-70.246v29.23h77.957v28.971zM538.577 528.307h-37.748l-18.881-29.654c-4.676-7.273-8.627-12.975-11.717-16.926-3.363-4.279-5.551-6.125-6.795-6.904-1.9-1.23-3.76-2.064-5.551-2.488-0.588-0.123-2.721-0.41-7.697-0.41h-12.496v56.383H406.89V387.336h63.301c12.264 0 21.533 1.271 28.314 3.883 7.355 2.857 13.275 7.889 17.582 14.971 4.184 6.877 6.316 14.547 6.316 22.791 0 10.828-3.596 20.111-10.664 27.59-3.965 4.197-9.092 7.533-15.34 9.953 4.662 4.594 9.078 10.104 13.18 16.434l28.998 45.349z m-100.885-84.93h29.121c6.836 0 12.059-0.656 15.572-1.969 2.939-1.066 5.018-2.639 6.426-4.826 1.518-2.379 2.27-4.867 2.27-7.602 0-4.006-1.326-7.041-4.184-9.57-2.967-2.639-8.504-4.033-16.023-4.033h-33.182v28z" fill="#333333"/><path d="M565.524 528.307h-30.789V387.336h54.893c8.9 0 15.627 0.438 20.576 1.326 7.082 1.189 13.316 3.555 18.375 7.041 5.223 3.623 9.434 8.654 12.51 14.957 3.021 6.193 4.566 13.057 4.566 20.398 0 12.551-4.088 23.379-12.154 32.156-8.34 9.064-22.203 13.467-42.41 13.467h-25.566v51.626z m0-80.61h25.84c11.266 0 16.27-2.324 18.484-4.279 3.049-2.721 4.484-6.48 4.484-11.854 0-3.855-0.902-7-2.748-9.598-1.75-2.461-3.896-3.992-6.768-4.785-0.943-0.246-4.32-0.875-13.809-0.875h-25.484v31.391zM929.087 746.168a141.475 141.475 0 0 0-9.98-24.049l23.037-23.051-59.391-59.391-23.051 23.037a142.939 142.939 0 0 0-24.049-9.98v-32.566h-84v32.566a143.606 143.606 0 0 0-24.062 9.98l-23.037-23.037-59.404 59.391 23.051 23.051a140.267 140.267 0 0 0-9.98 24.049h-32.566v84h32.566a140.445 140.445 0 0 0 9.98 24.062l-23.051 23.023 59.404 59.391 23.037-23.01a144.773 144.773 0 0 0 24.062 9.967v32.566h84v-32.566a144.06 144.06 0 0 0 24.049-9.967l23.051 23.01 59.391-59.391-23.037-23.023a141.48 141.48 0 0 0 9.98-24.062h32.566v-84h-32.566zM793.653 880.043c-50.75 0-91.875-41.125-91.875-91.875 0-50.736 41.125-91.875 91.875-91.875 50.736 0 91.875 41.139 91.875 91.875 0 50.75-41.138 91.875-91.875 91.875z" fill="#333333"/><path d="M585.021 742.326v-42h7.205l-5.1-5.1 29.695-29.695 59.391-59.391 29.695-29.695 5.113 5.1v-7.219H764.915c3.145-7.93 6.18-15.928 8.723-24.158h76.016v-196h-76.016a325.98 325.98 0 0 0-23.27-56.123l53.758-53.785-138.578-138.578-53.785 53.771a330.776 330.776 0 0 0-56.109-23.283V60.168h-196v76.002a331.327 331.327 0 0 0-56.123 23.283l-53.771-53.771L111.167 244.26l53.771 53.785a326.059 326.059 0 0 0-23.27 56.123H65.653v196h76.016a326.12 326.12 0 0 0 23.27 56.137l-53.771 53.744L249.76 798.627l53.771-53.703c17.814 9.338 36.572 17.172 56.123 23.242v76.002h196v-76.002c10.008-3.104 19.797-6.699 29.367-10.705v-15.135z m-127.368-75.797c-118.398 0-214.389-95.936-214.389-214.361 0-118.385 95.99-214.361 214.389-214.361s214.375 95.977 214.375 214.361c0 118.426-95.976 214.361-214.375 214.361z" fill="#333333"/></svg>
        <span class="fs-4">Mybizna Settings</span>
      </a>
    </header>

    <div class="mb-4 bg-light rounded-3">
      <div class="container-fluid py-2">
        <form action="options.php" method="post">
            <?php
settings_fields('mybizna_setting');
    do_settings_sections('mybizna_setting_section');
    ?>
            <input name="submit" class="button button-primary" type="submit" value="<?php esc_attr_e('Save');?>" />
        </form>
      </div>
    </div>

    <footer class="pt-3 mt-4 text-muted border-top text-center">
      &copy; <?php echo date('Y') ?>
    </footer>
  </div>
</main>


    <link href="<?php echo $assets_url; ?>/css/app.css" rel="stylesheet">

    <?php
}

function mybizna_setting_register_settings()
{
    register_setting('mybizna_setting', 'mybizna_setting', 'mybizna_setting_validate');
    add_settings_section('mybizna_setting_section', 'Main Settings', 'mybizna_setting_section_text', 'mybizna_setting_section');

    add_settings_field('frontend_manage', 'Allow Manage In Frontend', 'mybizna_setting_frontend_manage', 'mybizna_setting_section', 'mybizna_setting_section');
    add_settings_field('call_crons', ' Cron Linking', 'mybizna_setting_call_crons', 'mybizna_setting_section', 'mybizna_setting_section');
}
add_action('admin_init', 'mybizna_setting_register_settings');

function mybizna_setting_validate($input)
{
    /**
     * $newinput['frontend_manage'] = trim($input['frontend_manage']);
     *   if (!preg_match('/^[a-z0-9]{32}$/i', $newinput['frontend_manage'])) {
     *       $newinput['frontend_manage'] = '';
     *  }
     */

    return $input;
}

function mybizna_setting_section_text()
{
    echo '<p>Form for setting all Mybizna functionality within wordpress environment</p>';
}

function mybizna_setting_frontend_manage()
{
    $options = get_option('mybizna_setting');

    $checked = (is_array($options) && isset($options['frontend_manage'])) ? 'checked' : '';

    echo "<input id='mybizna_setting_frontend_manage' name='mybizna_setting[frontend_manage]' type='checkbox' value='1' " . $checked . " />";
    echo "<small>When admin is logged in it will add url: <b>" . site_url() . "/manage</b> .</small>";
}

function mybizna_setting_call_crons()
{
    $options = get_option('mybizna_setting');

    $checked = (is_array($options) && isset($options['call_crons'])) ? 'checked' : '';
    //$call_crons = (is_array($options) && isset($options['call_crons'])) ? $options['call_crons'] : false;

    echo "<input id='mybizna_setting_call_crons' name='mybizna_setting[call_crons]' type='checkbox' value='1' " . $checked . " />";
    echo "<small>All Mybizna Crons shall be called through wp cron call.</small>";
}

/**
 *
 *
 *
 *
 */

function my_admin_menu()
{
    add_menu_page(
        __('Mybizna', 'mybizna'),
        __('mybizna', 'mybizna'),
        'manage_options',
        'mybizna',
        'mybizna_contents',
        'dashicons-schedule',
        3
    );

    add_submenu_page('mybizna', 'Dashboard', 'Dashboard', 'manage_options', 'mybizna-dashboard', 'mybizna_contents');
    add_submenu_page('mybizna', 'Settings', 'Settings', 'manage_options', 'mybizna-settings', 'mybizna_setting_render_plugin_settings_page');
    remove_submenu_page('mybizna', 'mybizna');
}

function mybizna_contents($url = '', $is_frontend = false, $responsive_point = 2400)
{

    define('LARAVEL_START', microtime(true));

    /*
    |--------------------------------------------------------------------------
    | Check If The Application Is Under Maintenance
    |--------------------------------------------------------------------------
    |
    | If the application is in maintenance / demo mode via the "down" command
    | we will load this file so that any pre-rendered content can be shown
    | instead of starting the framework, which could cause an exception.
    |
     */

    if (file_exists($maintenance = __DIR__ . '/mybizna/storage/framework/maintenance.php')) {
        require $maintenance;
    }

    /*
    |--------------------------------------------------------------------------
    | Register The Auto Loader
    |--------------------------------------------------------------------------
    |
    | Composer provides a convenient, automatically generated class loader for
    | this application. We just need to utilize it! We'll simply require it
    | into the script here so we don't need to manually load our classes.
    |
     */

    spl_autoload_register(function ($class) {
        if (str_starts_with($class, 'Modules')) {
            $class_arr = explode('\\', $class);
            if ($class_arr[1] != 'Partner' && $class_arr[1] != 'Base' && $class_arr[1] != 'Core') {

                $paths = glob(WP_PLUGIN_DIR . '/*/Modules/' . $class_arr[1]);

                if (!empty($paths)) {

                    unset($class_arr[0]);
                    unset($class_arr[1]);

                    //print_r($paths[0]  . '/' . implode('/', $class_arr) . '.php');exit;

                    include $paths[0] . '/' . implode('/', $class_arr) . '.php';
                }

            }
        }
    });

    require __DIR__ . '/mybizna/vendor/autoload.php';

    /*
    |--------------------------------------------------------------------------
    | Run The Application
    |--------------------------------------------------------------------------
    |
    | Once we have the application, we can handle the incoming request using
    | the application's HTTP kernel. Then, we will send the response back
    | to this client's browser, allowing them to enjoy our application.
    |
     */
    $mybizna_wp_users = get_users(array('role__in' => array('administrator', 'admin', 'editor')));
    $user = wp_get_current_user();

    define('MYBIZNA_APPKEY', 'base64:wbvPP9pBOwifnwu84BeKAVzmwM4TLvcVFowLcPAi6nA=');
    define('MYBIZNA_URL', site_url());
    define('MYBIZNA_USER', $user);
    define('MYBIZNA_USER_EMAIL', $user->user_email);
    define('MYBIZNA_PLUGINS_URL', plugins_url());
    define('MYBIZNA_USER_LIST', $mybizna_wp_users);
    define('MYBIZNA_RESPONSIVE_POINT', $responsive_point);
    define('MYBIZNA_FLOATING_TOP', false);
    define('MYBIZNA_MARGIN_TOP', false);

    define('MYBIZNA_BASE_URL', site_url());
    define('MYBIZNA_ASSETS_URL',  'https://assets.mybizna.com/');

    $app = require_once __DIR__ . '/mybizna/bootstrap/app.php';

    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

    if ($url == '') {
        $url = (isset($_GET['url'])) ? $_GET['url'] : '/';
    }

    $show_routes = (isset($_GET['show_routes'])) ? $_GET['show_routes'] : false;

    $method = $_SERVER["REQUEST_METHOD"];
    $parameters = ($_POST) ? $_POST : $_GET;
    $cookies = $_COOKIE;
    $files = $_FILES;
    $server = $_SERVER;

    $response = $kernel->handle(
        //create(string $uri, string $method = 'GET', array $parameters = [], array $cookies = [], array $files = [], array $server = [], $content = null)
        $request = Illuminate\Http\Request::create($url, $method, $parameters, $cookies, $files, $server)
    )->send();

    /* if ($show_routes) {
    $routes = Illuminate\Support\Facades\Route::getRoutes();
    foreach ($routes as $route) {
    print_r($route->uri . "<br>");
    }
    }

    $app = app();*/

    $kernel->terminate($request, $response);

    if (str_contains($url, 'api') || str_contains($url, 'fetch_vue')) {
        exit;
    }

    ?>
        <style>
            .site-content .ast-container {
                display: block !important;
            }
        </style>
    <?php

}

function for_404_html_page($title, $message)
{
    $assets_url = plugins_url() . '/mybizna/mybizna/public/mybizna';
    ?>
        <script src="<?php echo $assets_url ?>/tailwind/tailwindcss.js"></script>

        <div class="lg:px-24 md:px-44 px-4 py-4 items-center flex justify-center flex-col-reverse lg:flex-row md:gap-28 gap-16">
            <div class="xl:pt-6 w-full xl:w-1/2 relative pb-6 lg:pb-0">
                <div class="relative">
                    <div class="absolute">
                        <div class="">
                            <h1 class="my-2 text-gray-800 font-bold text-2xl">
                                <?php echo $title; ?>
                            </h1>

                            <p class="my-2 text-gray-800">
                                <?php echo $message; ?>
                            </p>

                            <a href="<?php echo site_url() ?>" class="inline-block sm:w-full lg:w-auto my-4 border rounded  py-4 px-8 text-center bg-indigo-600 text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-700 focus:ring-opacity-50">
                                Go Home
                            </a>
                        </div>
                    </div>
                    <div>
                        <img src="<?php echo $assets_url ?>/images/404.png" />
                    </div>
                </div>
            </div>
            <div>
                <img class="w-96" src="<?php echo $assets_url ?>/images/disconnected.png" />
            </div>
        </div>


    <?php
}

if (isset($_GET['url']) && (str_contains($_GET['url'], 'api/') || str_contains($_GET['url'], 'fetch_vue/'))) {
    add_action('init', 'mybizna_contents');
} else {
    add_action('admin_menu', 'my_admin_menu');
}
