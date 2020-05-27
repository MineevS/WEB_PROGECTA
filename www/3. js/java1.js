//...

var i = 0;
var PSD = "divConteiner";
var elem1 = document.getElementById(PSD);

var CBX="checkbox";
var IdText="text1";

var top1 = 0;
var left1 = 5;
var HRT ="CoretHr";
var elemHr = document.getElementById(HRT);

var buf = 0;

var bufT = 0;
var idDiv;

function funcAddGroup()
{
	bufT+=1;
	//alert("Hello world!");
	var divLGroup = "divL";
	//divConteiner - указывает на элемент: divConteiner;
	var divConteiner1=document.getElementById(divLGroup);
	//div2Cont - указывает на элемент: div2;//Указываем куда создавать новый контейнет.
	var divLCont=document.getElementById("div2");//ФИКСИРОВАННО.
	//ClonDivConteiner - клон divConteiner;
	var ClonDivConteiner2=divConteiner1.cloneNode();
	//Функция добавления в конец div2Cont - divConteiner и ClonDivConteiner;
	divLCont.insertBefore(ClonDivConteiner2, divConteiner1);
	var elemL = document.getElementById(divLGroup);
	
	elemL.id = divLGroup + bufT;
	elemL.style.display = "block";
	
	idDiv = elemL.id;

	var checkboxTGroup = "checkboxT";
	//divConteiner - указывает на элемент: divConteiner;
	var checkboxConteiner1=document.getElementById(checkboxTGroup);
	//div2Cont - указывает на элемент: div2;//Указываем куда создавать новый контейнет.
	var checkboxCont=document.getElementById(idDiv);//ФИКСИРОВАННО.
	//ClonDivConteiner - клон divConteiner;
	var CloncheckboxConteiner2=checkboxConteiner1.cloneNode();
	//Функция добавления в конец div2Cont - divConteiner и ClonDivConteiner;
	checkboxCont.appendChild(CloncheckboxConteiner2, checkboxConteiner1);
	var elemR = document.getElementById(checkboxTGroup);

	elemR.id = checkboxTGroup + bufT;
	elemR.style.display = "block";

	var TextGroup = "textA";
	//divConteiner - указывает на элемент: divConteiner;
	var TextConteiner1=document.getElementById(TextGroup);
	//div2Cont - указывает на элемент: div2;//Указываем куда создавать новый контейнет.
	var TextCont=document.getElementById(idDiv);//ФИКСИРОВАННО.
	//ClonDivConteiner - клон divConteiner;
	var ClonTextConteiner2=TextConteiner1.cloneNode();
	//Функция добавления в конец div2Cont - divConteiner и ClonDivConteiner;
	TextCont.appendChild(ClonTextConteiner2, TextConteiner1);
	var elemT = document.getElementById(TextGroup);

	elemT.id = TextGroup + bufT;
	elemT.style.display = "block";
}

function funcAddfilter(idDiv)
{
	function Add(idDiv)
	{
		//divConteiner - указывает на элемент: divConteiner;
		var divConteiner=document.getElementById(PSD);
		//div2Cont - указывает на элемент: div2;//Указываем куда создавать новый контейнет.
		var div2Cont=document.getElementById(idDiv);//ФИКСИРОВАННО.
		//ClonDivConteiner - клон divConteiner;
		var ClonDivConteiner=divConteiner.cloneNode();
		//Функция добавления в конец div2Cont - divConteiner и ClonDivConteiner;
		div2Cont.appendChild(ClonDivConteiner, divConteiner);
		var elem = document.getElementById(PSD);
		++buf;

		elem.id =PSD+i;
		elem.style.display="block";
	
		var divCheckbox=document.getElementById(CBX);
		var divCon2 = document.getElementById(elem.id);
		var ClonCheckbox=divCheckbox.cloneNode();
		divCon2.appendChild(ClonCheckbox, divCheckbox);
		var elem2 = document.getElementById(CBX);
		elem2.id = CBX + i;
	
		$('#' + elem2.id).removeClass("checkboxCLass0");
		$('#' + elem2.id).addClass("checkboxCLass");

		var divText=document.getElementById(IdText);
		var divCon2 = document.getElementById(elem.id);
		var ClonText=divText.cloneNode();
		divCon2.appendChild(ClonText, divText);
		var elem3 = document.getElementById(IdText);
		elem3.id=IdText + i;

		elem3.style.left="1%";

		var IdText2="text2";
		var divText2=document.getElementById(IdText2);
		var divCon2 = document.getElementById(elem.id);
		var ClonText2=divText2.cloneNode();
		divCon2.appendChild(ClonText2, divText2);
		var elem4 = document.getElementById(IdText2);
		elem4.id=IdText2 + i;
		++i;
	}
	
	if(buf == 0)
	{
		//alert(i);
		i=++i;
		//alert(i);
		Add(idDiv);
	}
	else if(buf != 0)
	{
		//alert(i);//2//3//4
		//i= i ;//+ (buf)
		//alert(i);
		Add(idDiv);
	}
	
};

function funcDeletetfilter(idDiv)
{
	var arr1=document.getElementsByClassName("checkboxCLass");
	var arr2=document.getElementsByClassName("textA");
	var arr3=document.getElementsByClassName("divC");
	
	for(var z=0; z < arr1.length; z++)
	{
		for(var j=0; j < arr1.length; j++)
		{	
			var parent = document.getElementById(idDiv);
			
			if(arr1[j].checked == true)
			{	
				var child=document.getElementById(arr3[j].id);
				parent.removeChild(child);
			}
		}
	}
}

function funcDeletetGroup()
{
	var arrT1=document.getElementsByClassName("checkboxCLassT");
	var arrT2=document.getElementsByClassName("textA");
	var arrT3=document.getElementsByClassName("divLT");
	
	for(var z=0; z < arrT1.length; z++)
	{
		for(var j=0; j < arrT1.length; j++)
		{
			if(arrT1[j].checked == true)
			{	
				var child=document.getElementById(arrT3[j].id);
				
				child.parentNode.removeChild(child);
			}
		}
	}
}

function  funcAjax(idType, arr1)
{
	$.ajax({
		url: '../4. php/index1.php',
		method: 'GET',
		dataType: 'html' | 'json',//'html' 'json'
		data: {ID: idType, 'data': arr1}, //ID: idType
		success: function(Response)
		{
			var elem = document.getElementById("div3");
			
			var array = ["ОТПРАВЛЯЕМЫЕ ДАННЫЕ:"] + "<br/>"+ JSON.stringify(arr1) + "<br/><br/>"+ ["ОБРАБОТАННЫЕ ДАННЫЕ:"] + JSON.stringify(JSON.parse(Response), null, 4);
			
			elem.innerHTML = array;
		}
	});
}

function funcStart(id) //(На вход подается id) Функция для проверки наличия галочки у контейнера.
{
	var MasCheckboxTS=document.getElementsByClassName('checkboxCLassT');
	var MasCheckboxsTrueTSParent = new Array();
	var L1TS=MasCheckboxTS.length;
	
	for(indexT = 0 ; indexT < MasCheckboxTS.length; indexT++)
	{
		//alert(MasCheckboxTS[indexT].nextSibling.value);
		if(MasCheckboxTS[indexT].checked == true & MasCheckboxTS[indexT].nextSibling.value != false)
		{
			// Выделяем группы,в которых пользователь указал галочку и написал группу.
			MasCheckboxsTrueTSParent.push(MasCheckboxTS[indexT].parentNode);
		}
	}
	
	//MasCheckboxsTrueTSParent;//+
	//alert(MasCheckboxsTrueTSParent[0].id);//+
	//Положим в массив те контейнеры,которые отмечены галочкой.
	
	var masF = new Array();
	var LTR = MasCheckboxsTrueTSParent.length;
	
	//console.log(LTR);
	
	for(var q=0; q < LTR; q++ )
	{
		//MasCheckboxsTrueTSParent[0].firstChild.nextSibling - КМБО-05-19
		//masR.push("group" + MasCheckboxsTrueTSParent[q].firstChild.nextSibling.value);
		var GROUP = new Array();
		
		var obj = {"group" : MasCheckboxsTrueTSParent[q].firstChild.nextSibling.value};
		
		GROUP.push({"group" : MasCheckboxsTrueTSParent[q].firstChild.nextSibling.value});
		
		var ContS = $(MasCheckboxsTrueTSParent[q]).children(".divC");

		var arrW = ContS.get();
		
		for(f = 0; f < arrW.length; f++)
		{
			Cont = arrW[f];//Контейнер.
			
			if((Cont.firstChild.checked == true) & (Cont.firstChild.nextSibling.value != 0 & Cont.firstChild.nextSibling.nextSibling.value != 0))
			{
				var Param = Cont.firstChild.nextSibling.value;
				var Znach = Cont.firstChild.nextSibling.nextSibling.value;
				
				var obj2 = {[Param]: Znach};
				var array = Object.keys(obj);
				var elem = Object.keys(obj2);
				
				if (typeof obj[elem] != "undefined") 
				{
					//alert("Встретилась копия");
					
					//obj - основной массив(куда копируем.);
					//obj2 - что копируем.
					//elem - ключ проблемы.
					
					var der1 = obj[elem];
					var der2 = obj2[elem];
					var objR =[der1, der2];

					GROUP.push(obj2);
				}
				else
				{
					GROUP.push(obj2);
				}
			}
		}
		
		masF = masF.concat(GROUP);

		
		delete GROUP;
	}
	
	console.log(masF);//+
	funcAjax(id,masF);//+
}

