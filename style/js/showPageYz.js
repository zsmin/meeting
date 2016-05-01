/**
*=================================================================
*名称:			叶子js分页样式
*Name:			ShowoPage With JavaScript
*RCSfile:		showo_page.js
*Revision:		0.04Beta
*Author:		yezi(叶子)
*Date:			2005-01-21 17:50:10
*Description:	js分页样式，显示上一页下一页的翻页结果
*Contact:		QQ:311673,MSN:ishows@msn.com,http://www.showo.com
*=================================================================
*/

var url,CurrPage,re,CurrentPage,iurl,FirstPageUrl,PrevPageUrl,NextPageUrl,LastPageUrl,PageCount,prevpage,nextpage,PageStart,PageEnd,i,ipage;
	url=""+document.location;
	if (url.indexOf("Page=")==-1) {
		CurrPage=1;
	}
	else {
		re=/(\S.*)(Page=\d*)(\S.*|\S*)/g;
		CurrentPage=url.replace(re,"$2");
		CurrentPage=CurrentPage.replace("Page=","");
		//re=/(?:\S{1,}Page=|\D.*)/g;
		//CurrentPage=url.replace(re,"");
		url=url.replace("&Page="+CurrentPage,""); 
		url=url.replace("Page="+CurrentPage+"&","");
		url=url.replace("Page="+CurrentPage,"");
	}
	url+=(url.indexOf("?")==-1)?"?":"&";
	url=url.replace("?&","?");
	url=url.replace("&&","&");
function FromatPage(str,StartNum,EndNum) {
	str+="";
	if (str.length>=1) {
		mynum=parseInt(str,10);
		if (isNaN(mynum)) {
			mynum=StartNum;
		}
		else {
			if (EndNum>-1) {
				mynum=(mynum<StartNum)?StartNum:mynum;
				mynum=(mynum>EndNum)?EndNum:mynum;
			}
			else {
				mynum=(mynum<StartNum)?StartNum:mynum;
			}
		}
	}
	else {
		mynum=StartNum;
	}
	return (mynum);
}
function CheckPage(iPageCount) {
	url+='&Page=';
	url=url.replace("?&","?");
	url=url.replace("&&","&");
	ipage=Page.value;
	location.href(url+FromatPage(ipage,1,iPageCount));
}
function ShowoPage(Tabstart,Tabend,CurrPageFont1,CurrPageFont2,PageCountFont1,PageCountFont2,PrePageFont1,PrePageFont2,RecCountFont1,RecCountFont2,FirstFont,PrevFont,NextFont,LastFont,Jump,PageNumFont1,PageNumFont2,PageNumFont3,PageNumFont4,LinkFont1,LinkFont2,LinkFont3,LinkFont4,iRecCount,iRecPerPage,iPageNum) {
	RecCount=FromatPage(iRecCount,0,-1);
	RecPerPage=FromatPage(iRecPerPage,1,-1);
	PageNum=FromatPage(iPageNum,0,-1);
	PageCount=(RecCount%RecPerPage==0)?(RecCount/RecPerPage):(FromatPage((RecCount/RecPerPage),0,RecCount)+1);
	CurrPage=(PageCount>0)?(FromatPage(CurrentPage,1,PageCount)):(FromatPage(CurrentPage,0,PageCount));
	prevpage=FromatPage((CurrPage-1),1,PageCount);  
	nextpage=FromatPage((CurrPage+1),1,PageCount);    
	if (CurrPage<=1&&PageCount<=1) {
		FirstPageUrl="&nbsp;"+LinkFont3+FirstFont+LinkFont4+"&nbsp;";
		PrevPageUrl="&nbsp;"+LinkFont3+PrevFont+LinkFont4+"&nbsp;";
		NextPageUrl="&nbsp;"+LinkFont3+NextFont+LinkFont4+"&nbsp;";
		LastPageUrl="&nbsp;"+LinkFont3+LastFont+LinkFont4+"&nbsp;";
	}
	else if (CurrPage==1&&PageCount>1) {
		FirstPageUrl="&nbsp;"+LinkFont3+FirstFont+LinkFont4+"&nbsp;";
		PrevPageUrl="&nbsp;"+LinkFont3+PrevFont+LinkFont4+"&nbsp;";
		NextPageUrl="&nbsp;<A href=\""+url+"Page="+nextpage+"\">"+LinkFont1+NextFont+LinkFont2+"</A>&nbsp;";
		LastPageUrl="&nbsp;<A href=\""+url+"Page="+PageCount+"\">"+LinkFont1+LastFont+LinkFont2+"</A>&nbsp;";
	}
	else if (CurrPage==PageCount) {
		FirstPageUrl="&nbsp;<A href=\""+url+"Page=1\">"+LinkFont1+FirstFont+LinkFont2+"</A>&nbsp;";
		PrevPageUrl="&nbsp;<A href=\""+url+"Page="+prevpage+"\">"+LinkFont1+PrevFont+LinkFont2+"</A>&nbsp;";
		NextPageUrl="&nbsp;"+LinkFont3+NextFont+LinkFont4+"&nbsp;";
		LastPageUrl="&nbsp;"+LinkFont3+LastFont+LinkFont4+"&nbsp;";
	}
	else {
		FirstPageUrl="&nbsp;<A href=\""+url+"Page=1\">"+LinkFont1+FirstFont+LinkFont2+"</A>&nbsp;";
		PrevPageUrl="&nbsp;<A href=\""+url+"Page="+prevpage+"\">"+LinkFont1+PrevFont+LinkFont2+"</A>&nbsp;";
		NextPageUrl="&nbsp;<A href=\""+url+"Page="+nextpage+"\">"+LinkFont1+NextFont+LinkFont2+"</A>&nbsp;";
		LastPageUrl="&nbsp;<A href=\""+url+"Page="+PageCount+"\">"+LinkFont1+LastFont+LinkFont2+"</A>&nbsp;";
	}
	PageStart=FromatPage((CurrPage-PageNum),1,PageCount);  
	PageEnd=FromatPage((CurrPage+PageNum),1,PageCount);  
	document.write (CurrPageFont1+CurrPage+CurrPageFont2+PageCountFont1+PageCount+PageCountFont2+PrePageFont1);
	document.write (RecPerPage+PrePageFont2+RecCountFont1+RecCount+RecCountFont2+FirstPageUrl+PrevPageUrl);
	if (CurrPage>=1) {
		for (i=PageStart;i<=PageEnd;i++) {
			if (i!=CurrPage) {
				document.write ("&nbsp;<A href=\""+url+"Page="+i+"\">"+PageNumFont1+i+PageNumFont2+"</A>&nbsp;");
			}
			else {
				document.write ("&nbsp;"+PageNumFont3+i+PageNumFont4+"&nbsp;");
			}
		}
	}
	document.write (NextPageUrl+LastPageUrl+Jump);
	//document.write ("<INPUT type=\"text\" id=\"Page\" size=\"5\" maxlength=\"10\" onkeydown=\"if (event.keyCode==13) CheckPage("+PageCount+")\"><INPUT type=\"button\" value=\"Go\" onClick=\"CheckPage("+PageCount+")\">"+Tabend);
}