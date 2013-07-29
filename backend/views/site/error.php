

<div class="alert in alert-block alert-error">

    <strong>Error <?php echo $code; ?></strong>
    <?php echo CHtml::encode($message); 
            echo nl2br('<br>');
    
    ?>
    
    <?php
        if ($code==401)
        {
            
            echo 'If you believe you should have access to the requested resource,
                please contact Sytem Administrator';
            
            
        }
    
    ?>    
</div>
