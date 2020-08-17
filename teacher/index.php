<?php
if (!empty($_POST['check_list'])) {
    $list = array();
    foreach ($_POST['check_list'] as $check) {
        list($value, $id) = explode(',', $check);
        echo $value . ' | ' . $_POST['number_' . $id];
    }
}
?>



<form action="" method="post">
    <?php for ($i = 0; $i < 5; $i++) { ?>
        <label>
            <input type="checkbox" name="check_list[]" value="<?php echo 'Topic Name ,' . $i; ?>">
            <?php echo 'Topic Name ' . $i; ?>
        </label>
        <input type="text" name="number_<?php echo $i; ?>"><br>
    <?php } ?>

    <input type="submit" />
</form>








<?php
for ($i = 0; $i < $topics_count; $i++) {
    $row2 = mysqli_fetch_assoc($result2);
    $topic_id = $row2['id'];
    $topic_title = $row2['topic_title']; ?>

    <div class="col-lg-4 col-sm-10">
        <div class="topic custom-control custom-checkbox">
            <input type="checkbox" name="selected_topic[]" class="custom-control-input" value="<?php echo $topic_id; ?>" id="<?php echo $topic_id; ?>">
            <label class="custom-control-label" for="<?php echo $topic_id; ?>"><?php echo $topic_title; ?></label>
            <input type="number" name="questions_count" placeholder="#" class="form-control" id="<?php echo $topic_id; ?>">

        </div>
    </div>

<?php } ?>