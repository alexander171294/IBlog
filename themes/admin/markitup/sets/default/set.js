// ----------------------------------------------------------------------------
// markItUp!
// ----------------------------------------------------------------------------
// Copyright (C) 2011 Jay Salvat
// http://markitup.jaysalvat.com/
// ----------------------------------------------------------------------------
// Html tags
// http://en.wikipedia.org/wiki/html
// ----------------------------------------------------------------------------
// Basic set. Feel free to add more tags
// ----------------------------------------------------------------------------
var mySettings = {
	onShiftEnter:  	{keepDefault:false, replaceWith:'\n'},
	onCtrlEnter:  	{keepDefault:false, openWith:'\n[p]', closeWith:'[/p]'},
	onTab:    		{keepDefault:false, replaceWith:'    '},
	markupSet:  [ 	
		{name:'Bold', key:'B', openWith:'(!([strong]|!|[b])!)', closeWith:'(!([/strong]|!|[/b])!)' },
		{name:'Italic', key:'I', openWith:'(!([em]|!|[i])!)', closeWith:'(!([/em]|!|[/i])!)'  },
		{name:'Stroke through', key:'S', openWith:'[del]', closeWith:'[/del]' },
		{separator:'---------------' },
		{name:'Bulleted List', openWith:'[li]', closeWith:'[/li]', multiline:true, openBlockWith:'[ul]', closeBlockWith:'[/ul]'},
		{name:'Numeric List', openWith:'[li]', closeWith:'[/li]', multiline:true, openBlockWith:'[ol]', closeBlockWith:'[/ol]'},
		{separator:'---------------' },
		{name:'Picture', key:'P', replaceWith:'[img][![Source:!:http://]!][/img]' },
		{name:'Link', key:'L', openWith:'[url=[![Link:!:http://]!]]', closeWith:'[/url]', placeHolder:'Link...' },
		{separator:'---------------' },
		{name:'Clean', className:'clean', replaceWith:function(markitup) { return markitup.selection.replace(/<(.*?)>/g, "") } },		
	]
}
