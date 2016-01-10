<!DOCTYPE html>
<html>
    <head>
        <title>TODO supply a title</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <div><!--{       $data + 1}--><!--{       $data[0] + 1 }--><!--{       $data}--><!--{       $data}-->

</div>

      <!--{foreach from=$myArray item=foo }-->
        <li><!--{$start.index}-->-------<!--{$foo[0]     }--></li>
       <!--{/foreach}-->

        <!--{foreach from=$myArray item=foo2 }-->
        <li><!--{$start.index + 1}-->---------<!--{$foo2[0]     }--></li>
       <!--{/foreach}-->
       

     <!--{if $isflag - 1 == 1}-->
     <!--{$isflag}-->   
     <!--{elseif $isflag == 2}-->
     <!--{$isflag}-->  
     <!--{else}-->
     <!--{$isflag}-->  
     <!--{/if}-->
    </body>
</html>

