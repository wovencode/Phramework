  <div class="page-content login-screen-content">
	<div class="login-screen-title">{LangChangePassword}</div>
	{formHeader}
	  <div class="list">
	  
		<ul>
		
		 <li class="item-content item-input item-input-outline">
			<div class="item-media">
        		{slotPasswordCurrent}
      		</div>
			<div class="item-inner">
			  <div class="item-title item-label">{LangPassword} {LangCurrent}</div>
			  <div class="item-input-wrap">
				{formFieldPasswordCurrent}
			  </div>
			</div>
		  </li>
		
		  <li class="item-content item-input item-input-outline">
			<div class="item-media">
        		{slotPasswordNew}
      		</div>
			<div class="item-inner">
			  <div class="item-title item-label">{LangPassword} {LangNew}</div>
			  <div class="item-input-wrap">
				{formFieldPasswordNew}
			  </div>
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