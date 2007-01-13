--TEST--
Phar: delete a file within a .phar
--SKIPIF--
<?php if (!extension_loaded("phar")) print "skip"; ?>
--INI--
phar.readonly=0
phar.require_hash=0
--FILE--
<?php
$fname = dirname(__FILE__) . '/' . basename(__FILE__, '.php') . '.phar.php';
$pname = 'phar://' . $fname;
$file = "<?php __HALT_COMPILER(); ?>";

$files = array();
$files['a.php'] = '<?php echo "This is a\n"; ?>';
$files['b.php'] = '<?php echo "This is b\n"; ?>';
$files['b/c.php'] = '<?php echo "This is b/c\n"; ?>';
include 'phar_test.inc';

include $pname . '/a.php';
include $pname . '/b.php';
include $pname . '/b/c.php';
unlink($pname . '/b/c.php');
?>
===AFTER===
<?php
include $pname . '/a.php';
include $pname . '/b.php';
include $pname . '/b/c.php';
?>

===DONE===
--CLEAN--
<?php unlink(dirname(__FILE__) . '/' . basename(__FILE__, '.clean.php') . '.phar.php'); ?>
--EXPECTF--
This is a
This is b
This is b/c
===AFTER===
This is a
This is b

Warning: include(%sdelete_in_phar.phar.php/b/c.php): failed to open stream: phar error: "b/c.php" is not a file in phar "%sdelete_in_phar.phar.php" in %sdelete_in_phar.php on line %d

Warning: include(): Failed opening 'phar://%sdelete_in_phar.phar.php/b/c.php' for inclusion (include_path='.') in %sdelete_in_phar.php on line %d

===DONE===
		