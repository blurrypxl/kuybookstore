<?php
session_start();
include '../dbconnect.php';
date_default_timezone_set("Asia/Bangkok");
?>

<!doctype html>
<html class="no-js" lang="en">

<head>
	<meta charset="utf-8">
	<link rel="icon" type="image/png" href="../favicon.png">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Kelola Pesanan - Tokobuku</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Log Transaksi.xls");
?>

<body>
	<!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
	<!-- page title area end -->
	<div class="main-content-inner">
		<!-- market value area start -->
		<div class="row mt-5 mb-5">
			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<div class="d-sm-flex justify-content-between align-items-center mb-4">
							<?php
							print "<h2 align='right'>" . date("d-m-Y") . "</h2>"
							?>
							<h2>Log Transaksi</h2>
						</div>
						<div class="data-tables datatable-dark">
							<table id="dataTable3" class="table table-bordered" style="width:100%">
								<thead class="thead-dark">
									<tr>
										<th>No</th>
										<th>ID Pesanan</th>
										<th>Nama Customer</th>
										<th>ID Produk</th>
										<th>Nama Produk</th>
										<th>Tanggal Order</th>
										<th>Total</th>
										<th>Status</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$brgs = mysqli_query($conn, "SELECT * FROM cart c, detailorder d, produk p, login l WHERE c.userid=l.userid AND c.orderid=d.orderid AND p.idproduk=d.idproduk AND status='Selesai' ORDER BY idcart DESC");
									$no = 1;

									while ($p = mysqli_fetch_array($brgs)) {
										$orderids = $p['orderid'];
									?>

										<tr align="center">
											<td><?php echo $no++ ?></td>
											<td><strong><?php echo $p['orderid'] ?></strong></td>
											<td><?php echo $p['namalengkap'] ?></td>

											<td><?= $p['idproduk'] ?></td>
											<td><?= $p['namaproduk'] ?></td>

											<td><?php echo $p['tglorder'] ?></td>
											<td>Rp
												<?php
												// $ordid = $p['orderid'];

												// Mengambil data dari tabel detailorder & produk
												$hargaProduk = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM detailorder d, produk p WHERE orderid = '$orderids' AND d.idproduk=p.idproduk"));

												// Jika harga after = 0 maka, hitung harga before.
												// Jika harga after tidak = 0 maka, hitung harga after.
												if ($hargaProduk['hargaafter'] == 0) {
													$result1 = mysqli_query($conn, "SELECT SUM(d.qty*p.hargabefore) AS count FROM detailorder d, produk p where orderid='$orderids' and p.idproduk=d.idproduk order by d.idproduk ASC");
												}
												if (!$hargaProduk['hargaafter'] == 0) {
													$result1 = mysqli_query($conn, "SELECT SUM(d.qty*p.hargaafter) AS count FROM detailorder d, produk p where orderid='$orderids' and p.idproduk=d.idproduk order by d.idproduk ASC");
												}
												$cekrow = mysqli_num_rows($result1);
												$row1 = mysqli_fetch_assoc($result1);
												$count = $row1['count'];
												if ($cekrow > 0) {
													echo number_format($count);
												} else {
													echo 'No data';
												}
												?>
											</td>
											<td>
												<?php
												echo $p['status'];
												?>
											</td>
										</tr>
									<?php
									}
									?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- row area start-->
	</div>
	</div>
	<!-- main content area end -->
	<!-- footer area start-->
	<footer>
		<div class="footer-area px-4">
			<p class="text-right">Kuy Book Store &copy; 2021</p>
		</div>
	</footer>
	<!-- footer area end-->
	</div>
	<!-- page container area end -->

	<!-- jquery latest version -->
	<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
	<!-- bootstrap 4 js -->
	<script src="assets/js/popper.min.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/owl.carousel.min.js"></script>
	<script src="assets/js/metisMenu.min.js"></script>
	<script src="assets/js/jquery.slimscroll.min.js"></script>
	<script src="assets/js/jquery.slicknav.min.js"></script>
	<!-- Start datatable js -->
	<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>
	<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
	<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
	<script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
	<!-- start chart js -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
	<!-- start highcharts js -->
	<script src="https://code.highcharts.com/highcharts.js"></script>
	<!-- start zingchart js -->
	<script src="https://cdn.zingchart.com/zingchart.min.js"></script>
	<script>
		zingchart.MODULESDIR = "https://cdn.zingchart.com/modules/";
		ZC.LICENSE = ["569d52cefae586f634c54f86dc99e6a9", "ee6b7db5b51705a13dc2339db3edaf6d"];
	</script>
	<!-- all line chart activation -->
	<script src="assets/js/line-chart.js"></script>
	<!-- all pie chart -->
	<script src="assets/js/pie-chart.js"></script>
	<!-- others plugins -->
	<script src="assets/js/plugins.js"></script>
	<script src="assets/js/scripts.js"></script>
</body>

</html>