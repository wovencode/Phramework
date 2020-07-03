  <div class="page-content login-screen-content">
	<div class="login-screen-title">{LangChangeEmail}</div>
	{formHeader}
	  <div class="list">
	  
		<ul>
		  
		  <li class="item-content item-input item-input-outline">
			<div class="item-media">
        		{slotEmailCurrent}
      		</div>
			<div class="item-inner">
			  <div class="item-title item-label">{LangEmail} {LangCurrent}</div>
			  <div class="item-input-wrap">
				{formFieldEmailCurrent}
			  </div>
			</div>
		  </li>
		
		  <li class="item-content item-input item-input-outline">
			<div class="item-media">
        		{slotEmailNew}
      		</div>
			<div class="item-inner">
			  <div class="item-title item-label">{LangEmail} {LangNew}</div>
			  <div class="item-input-wrap">
				{formFieldEmailNew}
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