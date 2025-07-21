<?php require_once (APPROOT.'/views/inc/header.php'); ?>

<h1>BALICKY INDEX</h1>
<?php //var_dump($data);?>

<?php //echo "<br>"."<br>";?>



    <?php  foreach($data as $klic): ?>
    
    <?php  echo $klic['nazev']; ?> 
    
    <?php endforeach;?>
    
    <?php// echo $data['popis']['nazev']; ?>

    <a class="btn btn-dark" href="<?php echo URLROOT; ?>/posts/show/<?php echo $post->postId; ?>">More</a>


<?php require_once (APPROOT.'/views/inc/footer.php'); ?>