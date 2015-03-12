<!-- footer.php -->
      </div>
    </div>
    <div id="content_footer"></div>
    <div id="footer">
      Copyright &copy; myHistoryNotes.net |
      <a href="http://www.html5webtemplates.co.uk">design from HTML5webtemplates.co.uk</a>
    </div>
  </div>
  <?php
    $arr = array('main.php', 'register.php', 'login.php',
      'contact.php', 'post.php');
    if (in_array($page, $arr)) {
      $name = pathinfo($page)['filename'];
      echo '<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>';
      echo '<script src="js/jquery.validate.min.js"></script>';
      echo '<script src="js/' . $name . '.js"></script>';
    }
    if ($page == 'add_post.php') {
      // echo '<script src="js/tinymce/tinymce.min.js"></script>';
      // echo "<script>tinymce.init({selector:'textarea'});</script>";
    }
  ?>

</body>
</html>