<?php

$conn = $GLOBALS['conn'];

$tags = $conn->select('*', 'tags');
$imgs = $conn->select('*', 'images');

?>

<h1>browse by tag 🤣</h1>
<div class="card">
  <div class="card-body">
    <?php //foreach($tags as $tag){ ?>
      <!-- <button type="button" class="btn btn-primary">
        Notifications <span class="badge badge-light">4</span>
      </button> -->
    <?php //} ?>
  </div>
</div>

<hr/>

<div class="row">
  <?php foreach($imgs as $img){ ?>
    <div class="col-2">
      <div class="card">
        <div class="copyMeme" data-clipboard-text="<?= $img['link'] ?>">
          <span class="hideOverflow">
            <img class="card-img-top" src="<?= $img['link'] ?>" alt="">
          </span>
        </div>
        <?= $img['name'] ?>
      </div>
    </div>
  <?php } ?>
</div>

<script src="//cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.0/clipboard.min.js" charset="utf-8"></script>
<script type="text/javascript">
  function clearTooltip(e){
    e.currentTarget.setAttribute('class','copyMeme');
    e.currentTarget.removeAttribute('aria-label');
  }
  function showTooltip(e){
    e.setAttribute('class','copyMeme tooltipped tooltipped-n tooltipped-no-delay border p-2');
    e.setAttribute("aria-label","Copied!");
  }

  var clipboard = new ClipboardJS('.copyMeme');
  clipboard.on('success', function(e){
    e.clearSelection();
    showTooltip(e.trigger);
  });

  var btns = document.querySelectorAll('.copyMeme');
  for(var i = 0;i<btns.length;i++)
    btns[i].addEventListener('mouseleave',clearTooltip);
</script>
