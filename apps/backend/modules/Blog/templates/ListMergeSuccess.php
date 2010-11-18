<div id="sf_admin_container">
  <div  style="background:white">
    Внимание! Блог блог <?php echo $blog->getName()?> / <?php echo $blog->getTag()?> будет удалён после слияния!
    <form action="" method="GET">
      Блог, в который будет слит данный:
      <select name="newBlog">
        <?php foreach($blogs as $blog) : ?>
          <option value="<?php echo $blog->getId()?>"><?php echo $blog->getName()?> / <?php echo $blog->getTag()?></option>
        <?php endforeach ?>
      </select>
      <br/>
      <input type="submit" value="Слить" />
    </form>
  </div>
</div>
