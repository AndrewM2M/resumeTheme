<?php
use M2M\M2M;

if (M2M::isWP()) {
    M2M::WP_safety();
}
;

?>
<ul>
	<li>Identify what we are (plugin/theme/other??) &#x2714;</li>
    <li>Find what we are called. &#x2714;</li>
    <li>look for config. &#x2714;</li>
    <li>run config &#x2714;</li>
</ul>

<h1>M2M WP Component config</h1>

<h2>For Just Plugins</h2>

	<h3>As JSON Objects</h3>
<ul>
	<li>Custom Post Types</li>
	<li>Admin Pages</li>
	<li>Meta Boxes</li>
</ul>

<h2>For Both Plugins and Themes</h2>

	<h3>As arrays</h3>
<ul>
	<li>Dependencies (with composer?)</li>
	<li>Template Paths</li>
</ul>
	<h3>As JSON Objects</h3>
<ul>
	<li>Widgets</li>
	<li>Settings</li>
	<li>Sidebars</li>
</ul>

<?php
require_once BASE . 'M2M_DEPEND.php';
$dependentcies = array(
	'lib'		=>  	'/home/andrew/Documents/work/resumeTheme/content/plugins/resu_me/inc/lib/vendor/'
	);
print_r(M2M_DEPEND::check($dependentcies));
$configMessages = new M2M_MESSAGES;
var_dump($configMessages);
?>