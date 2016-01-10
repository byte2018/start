<?php use Core\Model\StartModel;?><!DOCTYPE html>
<html>
    <head>
        <title>TODO supply a title</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <div><?php echo $this->value['data']+ 1; ?><?php echo $this->value['data'][0]+ 1; ?><?php echo $this->value['data']; ?><?php echo $this->value['data']; ?>

</div>

      <?php $start = new StartModel(0);?><?php foreach ((array) $this->value['myArray'] as $k => $foo){ ?>
        <li><?php   echo $start->index++ ;?>-------<?php echo $foo[0]     ; ?></li>
       <?php } ?>

        <?php $start = new StartModel(0);?><?php foreach ((array) $this->value['myArray'] as $k => $foo2){ ?>
        <li><?php   echo $start->index++ + 1;?>---------<?php echo $foo2[0]     ; ?></li>
       <?php } ?>
       

     <?php if ($this->value['isflag'] - 1 == 1 ){ ?>
     <?php echo $this->value['isflag']; ?>   
     <?php }elseif($this->value['isflag'] == 2){ ?>
     <?php echo $this->value['isflag']; ?>  
     <?php }else{ ?>
     <?php echo $this->value['isflag']; ?>  
     <?php } ?>
    </body>
</html>

