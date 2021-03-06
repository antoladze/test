<?php $this->beginContent('//layouts/main') ?>
<div class="row">
    <div class="span9">
        <div id="content">
            <?= $content ?>
        </div>
    </div>
    <div class="span3">
        <div id="sidebar">
        <?php
            $this->beginWidget('zii.widgets.CPortlet', array(
                'title'=>'Operations',
            ));
            $this->widget('bootstrap.widgets.TbMenu', array(
                'items'=>$this->menu,
                'htmlOptions'=>array('class'=>'operations'),
            ));
            $this->endWidget();
        ?>
        </div>
    </div>
</div>
<?php $this->endContent() ?>