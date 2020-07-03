  <div class="page-content login-screen-content">
	<div class="login-screen-title">{LangRegister}</div>
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
        		{slotEmail}
      		</div>
			<div class="item-inner">
			  <div class="item-title item-label">{LangEmail}</div>
			  <div class="item-input-wrap">
				{formFieldEmail}
			  </div>
			</div>
		  </li>
		  <li class="item-content item-input item-input-outline">
		  	<div class="item-media">
        		
      		</div>
			<div class="item-inner">
			  <div class="item-title item-label">{LangLanguage}</div>
			  <div class="item-input-wrap">
				{formFieldLanguage}
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