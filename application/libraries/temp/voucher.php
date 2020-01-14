<!-- container section start -->
<section id="container" class="">
    <!--main content start-->
    <section id="main-content">
        <section class="wrapper">
            <div class="row">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li><a href="<?= base_url() . 'admin/dashboard' ?>"><i class="icon_house_alt"></i> Home</a></li>
                        <li class="active"><?= $title ?></a></li>
                    </ul>
                </div>
            </div>

            <div class="row">

                <div class="col-md-12">
                    <h3> <?= $title ?> </h3>
                    <section class="panel">
                        <header class="panel-heading">
                            <div class="row">
                                <div class="col-md-8">
                                    <a href="<?= base_url() . 'admin/voucher/create' ?>" class="btn btn-primary"
                                       data-toggle="modal"> <i class="icon_plus"></i> Add</a>
                                </div>
                        </header>


                        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1"
                             id="deleteform" class="modal fade">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×
                                        </button>
                                        <h4 class="modal-title">Delete <?= $title ?></h4>
                                    </div>
                                    <div class="modal-body">
                                        <p>Are you sure delete this point?</p>
                                        <form method="post" action="<?= base_url() . 'admin/voucher/delete' ?>">
                                            <input type="hidden" name="id" id="del_id" value="">
                                            <button type="submit" class="btn btn-danger">Sure</button>
                                            <button class="btn btn-info" data-dismiss="modal">Cancel</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- sukses update -->
                        <?php if ($this->session->flashdata('activationcode')) { ?>
                            <div class="alert alert-success fade in" id="alert">
                                <?php echo $this->session->flashdata('activationcode'); ?>
                            </div>
                        <?php } ?>
                        <?php if ($this->session->flashdata('message')) { ?>
                            <div class="alert alert-success fade in" id="alert">
                                <?php echo $this->session->flashdata('message'); ?>
                            </div>
                        <?php } ?>
                        <?php if ($this->session->flashdata('breakmessage')) { ?>
                            <div class="alert alert-block alert-danger fade in" id="alert">
                                <?php echo $this->session->flashdata('breakmessage'); ?>
                            </div>
                        <?php } ?>
                        
                        <div class="table-responsive">
                            <table class="table table-hover" id="data-table">
                                <thead>
                                <tr>
                                    <th class="col-md-2"><i class="icon_tag_alt"></i> Title</th>
                                    <th class="col-md-2"><i class="icon_tag_alt"></i> Title_ID</th>
                                    <th><i class="icon_building"></i> Tenant</th>
                                    <th><i class="icon_wallet"></i> Point</th>
                                    <th><i class="icon_bag"></i> Stock</th>
                                    <th><i class="icon_calendar"></i> Created</th>
                                    <th><i class="icon_calendar"></i> Expired</th>
                                    <th><i class="icon_cogs"></i> Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if (isset($vouchers) && !empty($vouchers)) {
                                    $i = 0;
                                    foreach ($vouchers as $voucher) { ?>
                                        <tr>
                                            <td><?= $voucher->title ?></td>
                                            <td><?= $voucher->title_id ?></td>
                                            <td><?= $voucher->tenant->name ?></td>
                                            <td><?= $voucher->point ?></td>
                                            <td><?= $voucher->stock ?></td>
                                            <td><?= $voucher->created_date ?></td>
                                            <td><?= $voucher->expired_date ?></td>
                                            <td>
                                                <div class="btn-group">
                                                    <a data-toggle="modal" class="btn btn-success update-point-rule"
                                                       href="<?= base_url() . 'admin/voucher/edit?id=' . $voucher->id ?>"><i
                                                                class="icon_pencil"></i></a>
                                                    <a data-toggle="modal" class="delete-phone btn btn-danger"
                                                       href="#deleteform" data-id="<?= $voucher->id ?>"><i
                                                                class="icon_trash_alt"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php $i++;
                                    }
                                } else { ?>
                                    <tr>
                                        <td colspan="6">No result found</td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </section>
                </div>


            </div>


        </section>
    </section>
    <!--main content end-->
</section>
<!-- container section end -->