  <div class="page-content login-screen-content">
	<div class="login-screen-title">{langLogin}</div>
	{formHeader}
	  <div class="list">
		<ul>
		  <li class="item-content item-input item-input-outline">
			<div class="item-media">
        		{slotUsername}
      		</div>
			<div class="item-inner">
			  <div class="item-title item-label">{LangUsername}</div>
			  <div class="item-input-wrap">
				{formFieldUsername}
			  </div>
			</div>
		  </li>
		  <li class="item-content item-input item-input-outline">
			<div class="item-media">
        		{slotPassword}
      		</div>
			<div class="item-inner">
			  <div class="item-title item-label">{LangPassword}</div>
			  <div class="item-input-wrap">
				{formFieldPassword}
			  </div>
			</div>
		  </li>
		  <li class="item-content item-input item-input-outline">
			<div class="item-media">

      		</div>
			<div class="item-inner">
				<label class="item-checkbox item-content">
        			{formFieldRememberMe}
       				<i class="icon icon-checkbox"></i>
        			<div class="item-inner">
          				<div class="item-title">{LangRememberMe}</div>
        			</div>
      			</label>
			</div>
		  </li>
		</ul>
	  </div>
	  <div class="list">
		<ul>
		  <li>
			{formSubmit}
		  </li>
		</ul>
		<div class="block-footer">{message}</div>
	  </div>
	{formFooter}
  </div>