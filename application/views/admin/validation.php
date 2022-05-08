<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
    if(validation_errors()){
        ?>
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <i class="icon-warning2"></i><strong>Oh snap!</strong> 
            <ul>
                <?php echo validation_errors(); ?>
            </ul>
        </div>
        <?php
    }
?>
<?php if($this->session->flashdata('success')){ ?>
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <i class="icon-tick"></i><strong>Well done!</strong> 
        <?php echo $this->session->flashdata('success'); ?>
    </div>
<?php } else if($this->session->flashdata('error')){  ?>
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <i class="icon-warning2"></i><strong>Oh snap!</strong> 
        <?php echo $this->session->flashdata('error'); ?>
    </div>
<?php } else if($this->session->flashdata('warning')){  ?>
    <div class="alert alert-warning">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <i class="icon-flash"></i><strong>Heads up!</strong> 
        <?php echo $this->session->flashdata('warning'); ?>
    </div>
<?php } else if($this->session->flashdata('info')){  ?>
    <div class="alert alert-info">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <i class="icon-info-large"></i><strong>Superb!</strong> 
        <?php echo $this->session->flashdata('info'); ?>
    </div>
<?php } ?>