<?php if(isset($errors)) { ?>
<div><h3><?php echo $errors; ?></h3></div>
<?php } else { ?>
<div class="container-fluid">
    <div class="row" id="top-content">
        <div class="col-sm-12">
            <div>
            <p class="label label-default"><?php echo $website; ?></p>
            </div>
            <br>
            <div>
            <span class="label label-info"><?php echo $website_title; ?></span>
            <span class="label <?php echo $label; ?>"><?php echo $website_status; ?></span>
            </div>
        </div>
    </div>
    <br>
    <div class="row" id="speed-result">
        <div class="col-sm-3">
            <div class="counter">
                <div class="<?php echo $score_msg; ?> text-center msg"><?php echo $score_msg; ?></div>
                <div class="count"><?php echo $score; ?>&nbsp;/&nbsp;100</div>
            </div>
        </div>
        <div class="col-sm-3"></div>
        <div class="col-sm-6 pull-right">
            <?php if($image) { ?>
            <img src="<?php echo $image; ?>" width="320" height="240" style="float: inherit;">
            <?php } ?>
        </div>
    </div>
    <br>
    <div class="row" id="stats-table">
        <div class="col-sm-6 table-responsive">
            <h3><?php echo $text_table_size; ?></h3>
            <table class="table">
                <thead>
                    <th><?php echo $text_field_content_type; ?></th>
                    <th><?php echo $text_field_content_size; ?></th>
                </thead>
                <?php foreach ($page_size_stats as $key => $value) { ?>
                <tr>
                    <td><?php echo $key; ?></td>
                    <td><?php echo $value; ?></td>
                </tr>
                <?php } ?>
            </table>
        </div>
        <div class="col-sm-6 table-responsive">
            <h3><?php echo $text_table_request; ?></h3>
            <table class="table">
                <thead>
                    <th><?php echo $text_field_content_type; ?></th>
                    <th><?php echo $text_field_content_request; ?></th>
                </thead>
                <?php foreach ($page_request_stats as $key => $value) { ?>
                <tr>
                    <td><?php echo $key; ?></td>
                    <td><?php echo $value; ?></td>
                </tr>
                <?php } ?>
            </table>
        </div>
    </div>
    <div class="row" id="optimizations">
        <div class="col-sm-12">
            <?php if($possible_optimisation) { ?>
            <h3><?php echo $text_possible_optimisation; ?></h3>
            <div class="panel-group">
                <?php $i=0; foreach ($possible_optimisation as $opt) { $i++?>
                <div class="panel panel-warning">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                        <a data-toggle="collapse" href="#collapse<?php echo $i; ?>"><?php echo $opt['rulename']; ?></a>
                        </h4>
                    </div>
                    <div id="collapse<?php echo $i; ?>" class="panel-collapse collapse"> 
                        <div class="note"><?php echo $opt['summary']; ?></div>
                        <?php if(isset($opt['urlblocks']['header'])) { ?>
                        <p><?php echo $opt['urlblocks']['header']; ?></p>
                        <?php } ?>
                        <?php if(isset($opt['urlblocks']['link'])) { ?>
                        <?php foreach ($opt['urlblocks']['link'] as $link) { ?>
                        <p><?php echo $link['link']; ?></p>
                        <ul class="list-group">
                            <?php foreach ($link['urls'] as $urls) { ?>
                            <li class="list-group-item"><?php echo $urls; ?></li>
                            <?php } ?>
                        </ul>
                        <?php } ?>
                        <?php } ?>
                    </div>
                </div>
                <?php } ?>
            </div>
            <?php } ?>
        </div>
    </div>
    <br>
    <div class="row" id="optimizations">
        <div class="col-sm-12">
            <?php if($optimisation_found) { ?>
            <h3><?php echo $text_optimisation_found; ?></h3>
            <div class="panel-group">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                        <a data-toggle="collapse" href="#found"><?php echo $text_optimisation_found; ?></a>
                        </h4>
                    </div>
                    <div id="found" class="panel-collapse collapse">
                        <ul class="list-group">
                            <?php foreach ($optimisation_found as $found) { ?>
                            <li class="list-group-item">
                                <h4><?php echo $found['rulename']; ?></h4>
                                <div><?php echo $found['summary']; ?></div>
                            </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</div>
<style type="text/css">
#top-content span{
    font-size: 16px;
}
#speed-result .counter{
    background-color: #EEEEEE;
}
#speed-result .counter .msg{
    text-transform: uppercase;
    font-size: 25px;
    font-weight: bolder;
    padding: 10px 0px 5px 0px;
}
#speed-result .counter .msg.poor{color: red;}
#speed-result .counter .msg.good{color: #fda100;}
#speed-result .counter .msg.excellent{color: #009a2d;}
#speed-result .counter .count{
    font-size: 20px;
    text-align: center;
    padding: 0px 0px 10px 0px;
}
#optimizations h3{
    font-weight: bolder;
}
#optimizations .panel-collapse .note{
    padding: 5px 0px 5px 15px;
    font-weight: 700;
    font-size: 13px;
}
#optimizations .panel-collapse p{
    font-size: 14px;
    padding: 5px 0px 5px 15px;
}
#optimizations .panel{
    background-color: #EEEEEE;
}
#stats-table .table-responsive h3{
    font-weight: 600;
}
</style>
<?php } ?>