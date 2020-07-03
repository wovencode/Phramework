<!DOCTYPE html>
<html class="{html-class}">

	<head>
		{PageHeaderPagelet}
	</head>
  
	<body class="{body-class} {body-color}">

		<div id="app">
			<div class="view view-main">
				<div data-name="{page-name}" class="page">

					{TopCurrencyBarPagelet}
					{FloatingActionButtonPagelet}
					{BottomNavbarPagelet}
					{ModalWindowPagelet}
	   
					<div class="page-content {page-content} hide-navbar-on-scroll hide-toolbar-on-scroll">
	   					{AccountChangePasswordScreenPagelet}
	   				</div>

				</div>
			</div>
		</div>

		{PageFooterPagelet}
		{TemporaryCache}
		
	</body>
  
</html>