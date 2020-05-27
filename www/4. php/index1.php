<?php 
	
	$Array = array();
	
	// Переменные:
	
		//Количество дней:
			$DAYS = 6;	//$GLOBALS["DAYS"]
			
		//Количество Пар:
			$PAR = 6;	//$GLOBALS["PAR"]
			
		//Дни недели:
			$WEEKDAYNAME = array("Понедельник", "Вторник", "Среда", "Четверг", "Пятница", "Суббота", "Воскресенье"); //$GLOBALS["WEEKDAYNAME"]
		
		//array_push($GLOBALS["Array"], $weekDayName[$day-1]);
		
	//было 28, a cтало 21 функций.
	
	function DayWeek($dayWeek)//Функция для выведения расписания на день.
	{//+
		$DayWeek = json_decode(json_encode($dayWeek), True);// Ассоциативный массив пары.

		$lenFri = count($DayWeek);
		
		if(!$lenFri)
		{
			$GLOBALS["Array"][count($GLOBALS["Array"]) - 1] = $GLOBALS["Array"][count($GLOBALS["Array"]) - 1] + array("_"=>"Расписание на данную пару отсутствует.");
		}
		else
		{
			for($sa = 0; $sa < $lenFri; $sa++)
			{
				$output = array_slice($DayWeek, $sa, 1, true);
				
				$key = array_keys($output)[0];// получение  ключа массива
				
				$znach = $output["$key"];
			
				switch($key)
				{
					case "name":
						$GLOBALS["Array"][count($GLOBALS["Array"]) - 1] = $GLOBALS["Array"][count($GLOBALS["Array"]) - 1] + array("Название пары" => $znach);
						break;
					case "type":
						$GLOBALS["Array"][count($GLOBALS["Array"]) - 1] = $GLOBALS["Array"][count($GLOBALS["Array"]) - 1] + array("Тип" => $znach);

						break;
					case "teacher":
						$GLOBALS["Array"][count($GLOBALS["Array"]) - 1] = $GLOBALS["Array"][count($GLOBALS["Array"]) - 1] + array("Преподователь" => $znach);
						break;
					case "room":
						$GLOBALS["Array"][count($GLOBALS["Array"]) - 1] = $GLOBALS["Array"][count($GLOBALS["Array"]) - 1] + array("Кабинет №" => $znach);
						break;
					case "week":
						$GLOBALS["Array"][count($GLOBALS["Array"]) - 1] = $GLOBALS["Array"][count($GLOBALS["Array"]) - 1] + array("Неделя" => $znach);
						break;
				}
			}
		}
	}

	function funcDay($znach, $Day)
	{//+
		DayWeek($Day[$znach - 1]);
	}

	function WeekDay($key, $znach, $data, $P)
	{//+
		if($znach != 0)
		{
			if($key == "Понедельник" | $key == "Вторник" | $key == "Среда"| $key == "Четверг"| $key == "Пятница" | $key == "Суббота")
			{
				$GLOBALS["Array"][count($GLOBALS["Array"]) - 1] = $GLOBALS["Array"][count($GLOBALS["Array"]) - 1] + array($P => $znach);
			}
			else
			{
				$GLOBALS["Array"][count($GLOBALS["Array"]) - 1] = $GLOBALS["Array"][count($GLOBALS["Array"]) - 1] + array($key => $znach);
			}
		}

		switch ($key)
		{
			case "Понедельник"://+
			{
				$Monday = $data[0];
				funcDay($znach, $Monday);//+
				break;
			}
			case "Вторник"://+ 
			{
				$Tuesday = $data[1];
				funcDay($znach, $Tuesday);//+
				break;//+
			}
			case "Среда"://+ 
			{
				$Wednesday = $data[2];
				funcDay($znach, $Wednesday);//+
				break;//+
			}
			case "Четверг"://+ 
			{
				$Thursday = $data[3];
				funcDay($znach, $Thursday);//+
				break;//+
			}
			case "Пятница"://+ 
			{
				$Friday = $data[4];//+
				funcDay($znach, $Friday);//+
				break;//+
			}
			case "Суббота"://+ 
			{
				$Saturday = $data[5];
				funcDay($znach, $Saturday);//+
				break;
			}
			case "Воскресенье"://+ 
			{
				$Sunday = $data[6];
				funcDay($znach, $Sunday);//+
				break;
			}
			
		}
	}

	function funcZall($Param, $data, $P)
	{//+
		for($re = 1 ;$re <= $GLOBALS["PAR"]; $re++ )
		{
			array_push($GLOBALS["Array"], array("День недели" => "$Param"));
			
			WeekDay($Param, $re, $data, $P);//+
		}
	}
	
	function funcNday($DayT, $Param, $Znach, $P)
	{//+
		$sar = 0;
		
		for($s = 0; $s < $GLOBALS["DAYS"];$s++)
		{
			$Par = $DayT[$s];

			if(strpos($Par->$P, $Znach) !== false) //strpos(); - Учитывает регистр. //stripos(); - Неучитывает регистр.
			{	
				$GLOBALS["Array"][count($GLOBALS["Array"]) - 1] = $GLOBALS["Array"][count($GLOBALS["Array"]) - 1] + array("Пара" => $s+1);
				
				DayWeek($Par);//Если надо вывести ещё и расписание на этот день.
			}
			else
			{
				$saq++;
				
				if($saq == $GLOBALS["DAYS"])
				{
					array_splice($GLOBALS["Array"], (count($GLOBALS["Array"]) - 1), 1);
				}
			}
		}
	}
	
	function filtersParser($data, $Param, $Znach, $P)
	{//+
		for($d=0; $d < $GLOBALS["DAYS"]; $d++)
		{
			$sar = 0;
		
			for($s = 0; $s < $GLOBALS["DAYS"];$s++)
			{
				$Par = $data[$d][$s];

				if(strpos($Par->$P, $Znach) !== false) //strpos(); - Учитывает регистр. //stripos(); - Неучитывает регистр.
				{	
					array_push($GLOBALS["Array"], array( "День недели" => $GLOBALS["WEEKDAYNAME"][$d]));
					
					$GLOBALS["Array"][count($GLOBALS["Array"]) - 1] = $GLOBALS["Array"][count($GLOBALS["Array"]) - 1] + array("Пара" => $s+1);
				
					DayWeek($data[$d][$s]);//Если надо вывести ещё и расписание на этот день.
				}
				else
				{
					$saq++;
				
					if($saq == $GLOBALS["DAYS"])
					{
						array_splice($GLOBALS["Array"], (count($GLOBALS["Array"]) - 1), 1);
					}
				}
			}
		}
	}
	
	function funcParser($Param, $Znach, $data)
	{//+
		$P = "Пара";
		
		if($Param == "teacher")//+
		{
			$P="teacher";
			
			array_push($GLOBALS["Array"], array("Учитель" => $Znach));
			
			filtersParser($data, $Param, $Znach, $P);
		}
		else if($Param == "type")//+
		{
			$P="type";

			array_push($GLOBALS["Array"], array("Тип" => $Znach));
			
			filtersParser($data, $Param, $Znach, $P);
		}
		else if($Param == "name")//+
		{
			$P="name";
			
			array_push($GLOBALS["Array"], array("Название пары" => $Znach));
			
			filtersParser($data, $Param, $Znach, $P);
		}
		else if($Param == "room")
		{
			$P="room";

			array_push($GLOBALS["Array"], array("Кабинет" => $Znach));
			
			filtersParser($data, $Param, $Znach, $P);
		}
		else if($Znach == "all")//+
		{
			funcZall($Param, $data, $P);
		}
		else 
		{
			$Param;
			
			WeekDay($Param, $Znach, $data, $P);//Передача параметра и значения в функцию.
		}
	}

	function AdditionalConditions($Param, $Znach, $Data)
	{//+
		if($Znach == "all")
		{
			funcParser($Param, $Znach, $Data);
		}
		else if(is_numeric($Znach)&& ($Param != "День") && ($Param != "Пара"))
		{
			funcParser($Param, $Znach, $Data);
			
		}else if($Param == "Учитель")
		{
			$Param = "teacher";
			
			funcParser($Param, $Znach, $Data);
		}
	}
	
	function WeekEvent($dataPara,$Znach, $day, $para, $data)
	{//+
		$M ="week";
		
		$GLOBALS["Array"][count($GLOBALS["Array"]) - 1] = $GLOBALS["Array"][count($GLOBALS["Array"]) - 1] + array("Пара" => $para);
		
		if($dataPara->$M == NULL | $dataPara->$M % 2 == 0)
		{
			DayWeek($dataPara);
		}
		else
		{
			$GLOBALS["Array"][count($GLOBALS["Array"]) - 1] = $GLOBALS["Array"][count($GLOBALS["Array"]) - 1] + array(" " => "-- По данной недели на этот день пары нет.");
		}
	}
	
	function WeekEventTwo($dataDay, $Znach, $day, $data)
	{//+
		for($sd = 0; $sd < $GLOBALS["DAYS"]; $sd++)
		{
			$para = $sd + 1;
			
			array_push($GLOBALS["Array"], array( "День недели" => $GLOBALS["WEEKDAYNAME"][$sd]));
			
			WeekEvent($dataDay[$sd], $Znach, $day, $para, $data);	
		}
	}
	
	function WeekOdd($dataPara,$Znach, $day, $para, $data)
	{//+
		$M ="week";
		
		$GLOBALS["Array"][count($GLOBALS["Array"]) - 1] = $GLOBALS["Array"][count($GLOBALS["Array"]) - 1] + array("Пара" => $para);
		
		if($dataPara->$M == NULL | $dataPara->$M % 2 == 1)
		{
			DayWeek($dataPara);
		}
		else
		{
			$GLOBALS["Array"][count($GLOBALS["Array"]) - 1] = $GLOBALS["Array"][count($GLOBALS["Array"]) - 1] + array(" " => "-- По данной недели на этот день пары нет.");
		}
	}
	
	function WeekOddTwo($dataDay, $Znach, $day, $data)
	{//+
		for($sd = 0; $sd < 6; $sd++)
		{
			$para = $sd + 1;
			
			array_push($GLOBALS["Array"], array( "День недели" => $GLOBALS["WEEKDAYNAME"][$sd]));
			
			WeekOdd($dataDay[$sd], $Znach, $day, $para, $data);	
		}
	}

	function funcWayk($Perem, $Znach, $data, $Znach1)//+-
	{//+
		if($Znach1 == "Четная")
		{
			array_push($GLOBALS["Array"], array("Неделя" => $Znach1));
			
			if($Perem == NULL)
			{
				for($sd = 0; $sd < 6; $sd++)
				{
					$day = $sd + 1;
					
					WeekEventTwo($data[$sd], $Znach1, $day, $data);
				}
			}
		}
		else if($Znach1 == "Нечетная")//Вывести расписание на четную неделю
		{
			array_push($GLOBALS["Array"], array("Неделя" => $Znach1));
			
			if($Perem == NULL)
			{
				for($sd = 0; $sd < 6; $sd++)
				{
					$day = $sd + 1;
					
					WeekOddTwo($data[$sd], $Znach1, $day, $data);
				}
			}
		}
		else //Цифра
		{
			array_push($GLOBALS["Array"], array("Неделя" => $Znach1));
		}
	}
	
	function WeekConditions($Stat, $Perem, $Znach, $data)//Обработка условий для недели.
	{//+
		if($Stat == "Четная")
		{
			if($Perem == "Тип")
			{//+
				for($i = 0; $i < count($data); $i++)
				{
					$Para = $data[$i];//День.
					
					for($j = 0; $j < count($data[$i]);$j++)//Пара.
					{
						$week = "week";
						$Type = "type";
						
						if($Para[$j]->$week == NULL | $Para[$j]->$week % 2 == 0)
						{
							array_push($GLOBALS["Array"], array("День недели" => $i+1 ));
							
							$GLOBALS["Array"][count($GLOBALS["Array"]) - 1] = $GLOBALS["Array"][count($GLOBALS["Array"]) - 1] + array("Пара" => $j+1);
							
							if($Para[$j]->$Type == $Znach)
							{
								DayWeek($Para[$j]);
							}
							else
							{
								array_splice($GLOBALS["Array"], (count($GLOBALS["Array"]) - 1), 1);
							}
						}
					}
				}
			}
			
			if($Perem == "Кабинет")//++
			{//+
				for($i = 0; $i < count($data); $i++)
				{
					$Para = $data[$i];//День.
					
					for($j = 0; $j < count($data[$i]);$j++)//Пара.
					{
						$week = "week";
						$room = "room";

						if($Para[$j]->$week == NULL | $Para[$j]->$week % 2 == 0)
						{
							array_push($GLOBALS["Array"], array("День недели" => $i+1 ));
							
							$GLOBALS["Array"][count($GLOBALS["Array"]) - 1] = $GLOBALS["Array"][count($GLOBALS["Array"]) - 1] + array("Пара" => $j+1);
							
							if($Para[$j]->$room == $Znach)
							{
								DayWeek($Para[$j]);
							}
							else
							{
								array_splice($GLOBALS["Array"], (count($GLOBALS["Array"]) - 1), 1);
							}
						}
					}
				}
			}
			
			if($Perem == "Учитель")//++
			{//+
				for($i = 0; $i < count($data); $i++)//День.
				{
					$Para = $data[$i];

					for($j = 0; $j < count($data[$i]);$j++)//Пара.
					{
						$week = "week";
						$teacher = "teacher";
						
						if($Para[$j]->$week == NULL | $Para[$j]->$week % 2 == 0)
						{
							array_push($GLOBALS["Array"], array("День недели" => $i+1 ));
							
							$GLOBALS["Array"][count($GLOBALS["Array"]) - 1] = $GLOBALS["Array"][count($GLOBALS["Array"]) - 1] + array("Пара" => $j+1);
						
							if($Para[$j]->$teacher == $Znach)
							{
								DayWeek($Para[$j]);
							}
							else
							{
								array_splice($GLOBALS["Array"], (count($GLOBALS["Array"]) - 1), 1);
							}
						}
					}
				}
			}
			
			if($Perem == "Название пары")
			{//+
				for($i = 0; $i < count($data); $i++) //День.
				{
					$Para = $data[$i];
					
					for($j = 0; $j < count($data[$i]);$j++)//Пара.
					{
						$week = "week";
						$Name = "name";
						
						if($Para[$j]->$week == NULL | $Para[$j]->$week % 2 == 0)
						{
							array_push($GLOBALS["Array"], array("День недели" => $i+1 ));
							
							$GLOBALS["Array"][count($GLOBALS["Array"]) - 1] = $GLOBALS["Array"][count($GLOBALS["Array"]) - 1] + array("Пара" => $j+1);
							
							if($Para[$j]->$Name == $Znach)
							{
								DayWeek($Para[$j]);
							}
							else
							{
								array_splice($GLOBALS["Array"], (count($GLOBALS["Array"]) - 1), 1);
							}
						}
					}
				}
			}
			
			if($Perem == "Пара")
			{
				for($i = 0; $i < count($data); $i++)//День.
				{
					$Para = $data[$i];
					
					for($j = 0; $j < count($data[$i]);$j++)//Пара.
					{
						$week = "week";
						$Name = "name";

						if($Para[$j]->$week == NULL | $Para[$j]->$week % 2 == 0)
						{
							array_push($GLOBALS["Array"], array("День недели" => $i+1 ));
							
							$GLOBALS["Array"][count($GLOBALS["Array"]) - 1] = $GLOBALS["Array"][count($GLOBALS["Array"]) - 1] + array("Пара" => $j+1);
							
							if($j == $Znach)
							{
								DayWeek($Para[$j-1]);
							}
							else
							{
								array_splice($GLOBALS["Array"], (count($GLOBALS["Array"]) - 1), 1);
							}
						}
					}
				}
			}
		}
		
		if($Stat == "Нечетная")
		{
			if($Perem == "Тип")
			{//+
				for($i = 0; $i < count($data); $i++)//День.
				{
					$Para = $data[$i];
					
					for($j = 0; $j < count($data[$i]);$j++)//Пара.
					{
						$week = "week";
						$Type = "type";
						
						if($Para[$j]->$week == NULL | $Para[$j]->$week % 2 == 1)
						{
							array_push($GLOBALS["Array"], array("День недели" => $i+1 ));
							
							$GLOBALS["Array"][count($GLOBALS["Array"]) - 1] = $GLOBALS["Array"][count($GLOBALS["Array"]) - 1] + array("Пара" => $j+1);
							
							if($Para[$j]->$Type == $Znach)
							{
								DayWeek($Para[$j]);
							}
							else
							{
								array_splice($GLOBALS["Array"], (count($GLOBALS["Array"]) - 1), 1);
							}
						}
					}
				}
			}
			
			if($Perem == "Кабинет")//++
			{//+
				for($i = 0; $i < count($data); $i++)//День.
				{
					$Para = $data[$i];
					
					for($j = 0; $j < count($data[$i]);$j++)//Пара.
					{
						$week = "week";
						$room = "room";

						if($Para[$j]->$week == NULL | $Para[$j]->$week % 2 == 1)
						{
							array_push($GLOBALS["Array"], array("День недели" => $i+1 ));
							
							$GLOBALS["Array"][count($GLOBALS["Array"]) - 1] = $GLOBALS["Array"][count($GLOBALS["Array"]) - 1] + array("Пара" => $j+1);
							
							if($Para[$j]->$room == $Znach)
							{
								DayWeek($Para[$j]);
							}
							else
							{
								array_splice($GLOBALS["Array"], (count($GLOBALS["Array"]) - 1), 1);
							}
						}
					}
				}
			}
			
			if($Perem == "Учитель")//++
			{//+
				for($i = 0; $i < count($data); $i++)//День.
				{
					$Para = $data[$i];

					for($j = 0; $j < count($data[$i]);$j++)//Пара.
					{
						$week = "week";
						$teacher = "teacher";
						
						if($Para[$j]->$week == NULL | $Para[$j]->$week % 2 == 1)
						{
							array_push($GLOBALS["Array"], array("День недели" => $i+1 ));
							
							$GLOBALS["Array"][count($GLOBALS["Array"]) - 1] = $GLOBALS["Array"][count($GLOBALS["Array"]) - 1] + array("Пара" => $j+1);
						
							if($Para[$j]->$teacher == $Znach)
							{
								DayWeek($Para[$j]);
							}
							else
							{
								array_splice($GLOBALS["Array"], (count($GLOBALS["Array"]) - 1), 1);
							}
						}
					}
				}
			}
			
			if($Perem == "Название пары")
			{//+
				for($i = 0; $i < count($data); $i++)//День.
				{
					$Para = $data[$i];
					
					for($j = 0; $j < count($data[$i]);$j++)//Пара.
					{
						$week = "week";
						$Name = "name";
						
						if($Para[$j]->$week == NULL | $Para[$j]->$week % 2 == 1)
						{
							array_push($GLOBALS["Array"], array("День недели" => $i+1 ));
							
							$GLOBALS["Array"][count($GLOBALS["Array"]) - 1] = $GLOBALS["Array"][count($GLOBALS["Array"]) - 1] + array("Пара" => $j+1);
							
							if($Para[$j]->$Name == $Znach)
							{
								DayWeek($Para[$j]);
							}
							else
							{
								array_splice($GLOBALS["Array"], (count($GLOBALS["Array"]) - 1), 1);
							}
						}
					}
				}
			}
			
			if($Perem == "Пара")
			{
				for($i = 0; $i < count($data); $i++)//День.
				{
					$Para = $data[$i];
					
					for($j = 0; $j < count($data[$i]);$j++)//Пара.
					{
						$week = "week";
						$Name = "name";

						if($Para[$j]->$week == NULL | $Para[$j]->$week % 2 == 1)
						{
							array_push($GLOBALS["Array"], array("День недели" => $i+1 ));
							
							$GLOBALS["Array"][count($GLOBALS["Array"]) - 1] = $GLOBALS["Array"][count($GLOBALS["Array"]) - 1] + array("Пара" => $j+1);
							
							if($j == $Znach)
							{
								DayWeek($Para[$j-1]);
							}
							else
							{
								array_splice($GLOBALS["Array"], (count($GLOBALS["Array"]) - 1), 1);
							}
						}
					}
				}
			}
		}
	}
	
	function funcWeekDayParam($WeekStat, $NumDay, $Perem1, $Znach1, $data)
	{//+
		if($WeekStat == "Четная")
		{
			$week = "week";
			
			$Day = $data[$NumDay - 1];//Полечили расписание на день.
			
			if($Perem1 == "Пара")
			{//+
				for($f = 0; $f < count($Day); $f++)
				{
					$Para = $Day[$f-1];
					
					if($f == $Znach1 && ($Para->$week == Null | $Para->$week % 2 == 0))
					{
						array_push($GLOBALS["Array"], array("День недели" => $NumDay));
						
						$GLOBALS["Array"][count($GLOBALS["Array"]) - 1] = $GLOBALS["Array"][count($GLOBALS["Array"]) - 1] + array("Пара" => $f );
						
						DayWeek($Para);
					}
				}
			}
			
			if($Perem1 == "Учитель")
			{//+
				for($f = 0; $f < count($Day); $f++)
				{
					$week = "week";
					$Para = $Day[$f-1];
					$teacher ="teacher";
					
					if($Para->$teacher == $Znach1 && ($Para->$week == Null | $Para->$week % 2 == 0))
					{
						array_push($GLOBALS["Array"], array("День недели" => $NumDay));
						
						$GLOBALS["Array"][count($GLOBALS["Array"]) - 1] = $GLOBALS["Array"][count($GLOBALS["Array"]) - 1] + array("Пара" => $f);
						
						DayWeek($Para);
					}
				}
			}
			
			if($Perem1 == "Кабинет")
			{//+
				for($f = 0; $f < count($Day); $f++)
				{
					$Para = $Day[$f-1];
					$room ="room";

					if(($Para->$room == $Znach1)&& ($Para->$week == null | $Para->$week % 2 == 0))
					{
						array_push($GLOBALS["Array"], array("Кабинет" => $Znach1));
						
						$GLOBALS["Array"][count($GLOBALS["Array"]) - 1] = $GLOBALS["Array"][count($GLOBALS["Array"]) - 1] + array("Пара" => $f);
						
						DayWeek($Para);
					}
				}
			}
			
			if($Perem1 == "Название пары")
			{//+
				for($f = 0; $f < count($Day); $f++)
				{
					$Para = $Day[$f-1];
					$name ="name";
					if($Para->$name == $Znach1 && ($Para->$week == Null | $Para->$week % 2 == 0))
					{
						array_push($GLOBALS["Array"], array("Название пары" => $Znach1));
						
						$GLOBALS["Array"][count($GLOBALS["Array"]) - 1] = $GLOBALS["Array"][count($GLOBALS["Array"]) - 1] + array("Пара" => $f);
						
						DayWeek($Para);
					}
				}
			}
			
			if($Perem1 == "Тип")
			{//+
				for($f = 0; $f < count($Day); $f++)
				{
					$Para = $Day[$f-1];
					$type ="type";
					
					if($Para->$type == $Znach1 && ($Para->$week == Null | $Para->$week % 2 == 0))
					{
						array_push($GLOBALS["Array"], array("День недели" => $NumDay));
						
						$GLOBALS["Array"][count($GLOBALS["Array"]) - 1] = $GLOBALS["Array"][count($GLOBALS["Array"]) - 1] + array("Пара" => $f);
						
						DayWeek($Para);
					}
				}
			}
		}
		
		if($WeekStat == "Нечетная")
		{
			$week = "week";
			
			$Day = $data[$NumDay - 1];//Полечили расписание на день.
			
			if($Perem1 == "Пара")
			{
				for($f = 0; $f < count($Day); $f++)
				{
					$Para = $Day[$f-1];
					
					if($f == $Znach1 && ($Para->$week == Null | $Para->$week % 2 == 1))
					{
						DayWeek($Para);
					}
				}
			}
			
			if($Perem1 == "Учитель")
			{
				for($f = 0; $f < count($Day); $f++)
				{
					$week = "week";
					$Para = $Day[$f-1];
					$teacher ="teacher";
					
					if($Para->$teacher == $Znach1 && ($Para->$week == Null | $Para->$week % 2 == 1))
					{
						array_push($GLOBALS["Array"], array("Пара" => $f));

						DayWeek($Para);
					}
				}
			}
			
			if($Perem1 == "Кабинет")
			{
				for($f = 0; $f < count($Day); $f++)
				{
					$Para = $Day[$f-1];
					$room ="room";
					
					if($Para->$room == $Znach1 && ($Para->$week == Null | $Para->$week % 2 == 1))
					{
						array_push($GLOBALS["Array"], array("Пара" => $f));
						
						DayWeek($Para);
					}
				}
			}
			
			if($Perem1 == "Название пары")
			{
				for($f = 0; $f < count($Day); $f++)
				{
					$Para = $Day[$f-1];
					$name ="name";
					
					if($Para->$name == $Znach1 && ($Para->$week == Null | $Para->$week % 2 == 1))
					{
						array_push($GLOBALS["Array"], array("Пара" => $f));
						
						DayWeek($Para);
					}
				}
			}
			
			if($Perem1 == "Тип")
			{
				for($f = 0; $f < count($Day); $f++)
				{
					$Para = $Day[$f-1];
					$type ="type";
					
					if($Para->$type == $Znach1 && ($Para->$week == Null | $Para->$week % 2 == 1))
					{
						array_push($GLOBALS["Array"], array("Пара" => $f));
						
						DayWeek($Para);
					}
				}
			}
		}
	}
	
	function filters($ArrayGroup)
	{//+
		for($i = 0; $i < count($ArrayGroup); $i++)
		{
			$key = array_keys($ArrayGroup[$i])[0];
			
			if($key == "group")
			{
				$groupT = "Группа";

				$Group = $ArrayGroup[$i][$key];

				array_push($GLOBALS["Array"], array($groupT => $Group));
				
				$filelist = glob("../6. JSON/*.json");

				$str3 = 0;
				$str2 = 1;
				
				for($weg = 0; $str3 != $str2; $weg++)
				{
					$str = explode("../6. JSON/", $filelist[$weg]);
				
					$str2 = preg_replace("/[^0-9]/", '', $str[$weg]);
				
					$str3 = preg_replace("/[^0-9]/", '', $Group);
				
					if($str3 == $str2)
					{
						$f_json = $filelist[$weg];
						break;
					}
				}
	
				$data = JSON($f_json);
				
				$i++;
				
				if($i >= count($ArrayGroup))
				{
					break;
				}
				else
				{
					$Perem = array_keys($ArrayGroup[$i])[0]/*Const*/;
					$Znach = $ArrayGroup[$i][array_keys($ArrayGroup[$i])[0]/*Const*/];
				}
				
				while($Perem != NULL && $Perem != "group")
				{
					if($Perem == "Расписание" && $Znach == "all")//+
					{
						for($k = 0; $k < $GLOBALS["DAYS"]; $k++ )
						{
							for($j = 0; $j < $GLOBALS["PAR"]; $j++)
							{
								array_push($GLOBALS["Array"], array( "День недели" => $GLOBALS["WEEKDAYNAME"][$k]));
								
								$GLOBALS["Array"][count($GLOBALS["Array"]) - 1] = $GLOBALS["Array"][count($GLOBALS["Array"]) - 1] + array("Пара" => $j+1);
								
								funcDay($k, $data[$j]);
							}
						}
					}
					
					if($Perem == "Неделя")//+
					{
						if($Perem == "Неделя")
						{
							$Stat = $Znach;
						}
						
						if(count($Znach)> 1)
						{
							for($si = 0; $si < count($Znach); $si++ )
							{
								funcWayk($ArrayGroup, $data, $Znach[$si]);
							}
						}
						else
						{
							$i++;
						
							if($i >= count($ArrayGroup))//Промежуточное.
							{
								for($sd = 0; $sd < $GLOBALS["DAYS"]; $sd++)
								{
									$day = $sd + 1;
									
									if($Stat == "Четная")
									{
										for($st = 0; $st < $GLOBALS["DAYS"]; $st++)
										{
											array_push($GLOBALS["Array"], array( "День недели" => $GLOBALS["WEEKDAYNAME"][$sd]));
			
											$para = $st + 1;
											
											WeekEvent($data[$sd][$st], $Znach, $day, $para, $data);	
										}
									}
									else if($Stat == "Нечетная")
									{
										for($st = 0; $st < $GLOBALS["DAYS"]; $st++)
										{
											array_push($GLOBALS["Array"], array( "День недели" => $GLOBALS["WEEKDAYNAME"][$sd]));
			
											$para = $st + 1;

											WeekOdd($data[$sd][$st], $Znach, $day, $para, $data);	
										}
									}
								}
								
								break;	
							}
							else
							{	
								$Perem = array_keys($ArrayGroup[$i])[0];
								$Znach = $ArrayGroup[$i][array_keys($ArrayGroup[$i])[0]];	
							}

							while($Perem != NULL && $Perem != "Расписание")
							{
								if($Perem == "День")
								{
									$i++;
									
									if($i >= count($ArrayGroup))
									{
										$dayT = $data[$Znach - 1];
										
										array_push($GLOBALS["Array"], array("День недели" => $Znach));
										
										for($ter = 0; $ter < count($dayT); $ter++)
										{
											$Week = "week";
											$Par = $dayT[$ter];
											$name = "name";
											
											if($Stat == "Четная")
											{//+
												
												if((($Par->$Week == null) | ($Par->$Week % 2 == 0)) & ($Par->$name != null))//
												{
													array_push($GLOBALS["Array"], array("Пара" => $ter));
													
													DayWeek($Par);
												}
											}
											
											if($Stat == "Нечетная")
											{//+
												if((($Par->$Week == null) | ($Par->$Week % 2 == 1)) & ($Par->$name != null))//
												{
													array_push($GLOBALS["Array"], array("Пара" => $ter));
													
													DayWeek($Par);
												}
											}
										}
										
										break;
									}
									else
									{
										$Perem1 = array_keys($ArrayGroup[$i])[0];
										$Znach1 = $ArrayGroup[$i][array_keys($ArrayGroup[$i])[0]];	
									}
								
									while($Perem1 != NULL && $Perem1 != "Расписание")
									{
										$NumDay = $Znach;

										funcWeekDayParam($Stat, $NumDay, $Perem1, $Znach1, $data);

										$i++;
										
										if($i >= count($ArrayGroup))
										{
											break;
										}
										else
										{	
											$Perem1 = array_keys($ArrayGroup[$i])[0];
											$Znach1 = $ArrayGroup[$i][array_keys($ArrayGroup[$i])[0]];
										}
									}
								}
								else
								{
									WeekConditions($Stat, $Perem, $Znach-1, $data);
								}
								
								$i++;
								
								if($i >= count($ArrayGroup))
								{
									break;	
								}
								else
								{	
									$Perem = array_keys($ArrayGroup[$i])[0];
									$Znach = $ArrayGroup[$i][array_keys($ArrayGroup[$i])[0]];	
								}
								
								if($Perem == "Расписание")
								{
									$i--;
									break;
								}
							}

							if($Perem == "Расписание")
							{
								$i--;
								$Perem = array_keys($ArrayGroup[$i])[0];
								$Znach = $ArrayGroup[$i][array_keys($ArrayGroup[$i])[0]];

								if($Perem == "Неделя")
								{
									$Stat = $Znach;
									for($sd = 0; $sd < $GLOBALS["DAYS"]; $sd++)
									{
										$day = $sd + 1;
								
										if($Stat == "Четная")
										{
											WeekEventTwo($data[$sd], $Stat, $day, $data);
										}
										else if($Stat == "Нечетная")
										{
											WeekOddTwo($data[$sd], $Stat, $day, $data);
										}
									}
									
									$i--;
									
									$Perem = array_keys($ArrayGroup[$i])[0];
									$Znach = $ArrayGroup[$i][array_keys($ArrayGroup[$i])[0]];
								}
							}
							
							$i++;
							
							if($i >= count($ArrayGroup))
							{
								break;	
							}
							else
							{	
								$Perem = array_keys($ArrayGroup[$i])[0];
								$Znach = $ArrayGroup[$i][array_keys($ArrayGroup[$i])[0]];	
							}
						}
					}
				
					if($Perem == "Название пары")//+
					{
						$Perem = "name";
					
						funcParser($Perem, $Znach, $data);
					}
					
					if($Perem == "Кабинет")//+
					{
						$Perem = "room";
					
						funcParser($Perem, $Znach, $data);
					}
					
					if($Perem == "Тип")//+
					{
						$Perem = "type";
					
						funcParser($Perem, $Znach, $data);
					}
					
					if($Perem == "Учитель")//+
					{
						$Perem = "teacher";
					
						funcParser($Perem, $Znach, $data);
					}
					
					$dataY;

					if($Perem == "День")//+
					{
						$elem1 = $GLOBALS["WEEKDAYNAME"][$Znach - 1];
						
						$Per = $Znach;
						
						$i++;
						
						if($i >= count($ArrayGroup))//Промежуточное.
						{
							end:
							
							for($L = 0; $L < count($data[$Znach-1]); $L++)
							{
								array_push($GLOBALS["Array"], array("День недели" => $elem1));
							
								$GLOBALS["Array"][count($GLOBALS["Array"]) - 1] = $GLOBALS["Array"][count($GLOBALS["Array"]) - 1] + array("Пара" => $L+1);
							
								if((is_numeric(array_keys($data[$Znach-1])[$L]) == true & $L == (count($data[$Znach-1]) - 1)))
								{
									$GLOBALS["Array"][count($GLOBALS["Array"]) - 1] = $GLOBALS["Array"][count($GLOBALS["Array"]) - 1] + array("_" =>"Расписание на данную пару отсутствует.");
								}
								else
								{
									DayWeek($data[$Znach-1][$L]);
								}
							}
							
							break;	
						}
						else
						{
							$Perem = array_keys($ArrayGroup[$i])[0];
							$Znach = $ArrayGroup[$i][array_keys($ArrayGroup[$i])[0]];	
						}
						
						while($Perem != NULL && $Perem != "group")
						{
							array_push($GLOBALS["Array"], array("День недели" => $elem1));
							
							if($Perem == "Пара")
							{
								funcParser($elem1,$Znach,$data);
							}
							
							if($Perem == "Название пары")
							{
								$name = "name";
								
								$GLOBALS["Array"][count($GLOBALS["Array"]) - 1] = $GLOBALS["Array"][count($GLOBALS["Array"]) - 1] + array("$Perem" => $Znach);
								
								funcNday($data[$Per - 1], $Perem, $Znach, $name);
							}
							
							if($Perem == "Кабинет")//+
							{
								$room = "room";
								
								funcNday($data[$Per - 1], $Perem, $Znach, $room);
							}
							
							if($Perem == "Учитель")
							{
								$teacher = "teacher";
								
								funcNday($data[$Per-1], $Perem, $Znach, $teacher);
							}
							
							if($Perem == "Тип")
							{
								$type = "type";

								funcNday($data[$Per - 1],$Perem,$Znach,$type);
							}
							else if($Perem == "Понедельник" | $Perem == "Вторник" | $Perem == "Среда"| $Perem == "Четверг"| $Perem == "Пятница" | $Perem == "Суббота")
							{
								$i--;
								
								$Perem = array_keys($ArrayGroup[$i])[0];
								$Znach = $ArrayGroup[$i][array_keys($ArrayGroup[$i])[0]];
				
								goto end;
								
								break;
							}
							else
							{
								AdditionalConditions($Perem, $Znach, $data);
							}
							
							$i++;
							
							if($i >= count($ArrayGroup))
							{
								break;	
							}
							else
							{	
								$Perem = array_keys($ArrayGroup[$i])[0];
								$Znach = $ArrayGroup[$i][array_keys($ArrayGroup[$i])[0]];	
							}
							
							if($Perem == "День")
							{
								break;
							}
						}
						
						if($Perem == "День")
						{
							$i--;
							$Perem = array_keys($ArrayGroup[$i])[0];
							$Znach = $ArrayGroup[$i][array_keys($ArrayGroup[$i])[0]];
							continue;
						}

						if($Perem == "group")
						{
							$i--;
							break;
						}
						else
						{
							break;
						}
					}

					if($Perem == "Понедельник" | $Perem == "Вторник" | $Perem == "Среда"| $Perem == "Четверг"| $Perem == "Пятница" | $Perem == "Суббота")//+
					{
						funcParser($Perem, $Znach, $data);
					}
					
					$i++;
					
					if($i >= count($ArrayGroup))
					{
						break;	
					}
					else
					{	
						$Perem = array_keys($ArrayGroup[$i])[0];
						$Znach = $ArrayGroup[$i][array_keys($ArrayGroup[$i])[0]];
					}
					
					if($Perem == "group")
					{
						$i--;
						break;
					}
				}
			}
		}
	}

	function StartFunc()//Функция распоковки массива полученного из формы и отправки значений в WeekDay().
	{//+
		$ArrayGroups = $_GET['data'];
		
		filters($ArrayGroups);
	}
	
	function ERRORJSON($array)//Функция для проверки наличия ошибок. JSON массива.(В данном случае пока не используется.)
	{//+
		switch (json_last_error()) // Проверка наличия ошибок в JSON файле.
		{
			case JSON_ERROR_NONE:
				array_push($GLOBALS["Array"], array("Ошибок нет"));
				break;
			case JSON_ERROR_DEPTH:
				array_push($GLOBALS["Array"], array("Достигнута максимальная глубина стека"));
				break;
			case JSON_ERROR_STATE_MISMATCH:
				array_push($GLOBALS["Array"], array("Некорректные разряды или несоответствие режимов"));
				break;
			case JSON_ERROR_CTRL_CHAR:
				array_push($GLOBALS["Array"], array("Некорректный управляющий символ"));
				break;
			case JSON_ERROR_SYNTAX:
				array_push($GLOBALS["Array"], array("Синтаксическая ошибка, некорректный JSON"));
				break;
			case JSON_ERROR_UTF8:
				array_push($GLOBALS["Array"], array("Некорректные символы UTF-8, возможно неверно закодирован"));
				break;
			default:
				array_push($GLOBALS["Array"], array("Неизвестная ошибка"));
				break; 
		}
	}
	
	function JSON($f_json)//Функция подключения JSON файла и проверки ошибок.
	{//+
		$json = file_get_contents("$f_json"); //$f_json - Переменная содержит директорию подключаемого файла.
		
		$mas = json_decode($json); //массив

		//ERRORJSON($mas);// Проверка наличия ошибок при чтениии JSON файла.
		
		return $mas;
	}
	
	function funcURL()//+//Дополнительная функция для обращения непосредственно к серверу.(В данном случае пока не используется.)
	{//+
		function getUrlParams($elemP) //Функция отделения входящих параметров от их значений и между собой.
		{ 	
			$a = explode("&", $elemP); 
		
			if (!(count($a) == 1 && $a[0] == "")) 
			{ 
				foreach ($a as $key => $value) 
				{ 
					$b = explode("=", $value); 
					$a[$b[0]] = $b[1]; 
					unset ($a[$key]); 
				
				} return $a;
			} 
			else { return false; } 
		}
		
		$elemP=$_SERVER['QUERY_STRING'];

		$ves = getUrlParams($elemP);

		$len1=count($ves);
		
		for($sa=0; $sa < $len1; $sa++)
		{
			$output = array_slice($ves, $sa, 1, true);//Array0 ( [dfdfdfd] => 3 )
			
			$keys = array_keys($output);// получение  ключа массива
		
			$key=$keys[0];

			$znach = $output["$key"];
			
			array_push($GLOBALS["Array"], array($key => $znach));

			//WeekDay($key, $znach);//Подключение функции для работы с полученными параметрами.
		}
	}
	
	function Start()// Функция непосредственного запуска.
	{//+
		if($_SERVER['QUERY_STRING'])//===/Режим обращения через форму.
		{
			if($_GET['ID'])
			{
				StartFunc();
				
				$json = json_encode($GLOBALS["Array"]);
		
				print($json);
			}
		}
		
		if($_SERVER['QUERY_STRING'])//===/Режим непосредственного обращения к "*.php" если указаны параметры.
		{
			if(!$_GET['ID']) //Подключения функции для отделения от URL переданных параметров.
			{
				funcURL();//+
			}
		}
		else if(!$_SERVER['QUERY_STRING'])//===/Режим непосредственного обращения к "*.php" если не указаны параметры.
		{
			array_push($GLOBALS["Array"], array("NOT PARAMS!"));
			
			$json = json_encode($GLOBALS["Array"]);
		
			print($json);
		}
	}
	
	Start();
?>