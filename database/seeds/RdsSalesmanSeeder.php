<?php

use Illuminate\Database\Seeder;

class RdsSalesmanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('rds_salesman')->truncate();
    	$today = new DateTime();
    	$salesman = [
    			['area_name'=>'SOUTHERN CEBU','area_code'=>'','salesman_name'=>'TERO, RENATO','salesman_code'=>'A09','jr_salesman_name'=>null,'created_at'=>$today,'updated_at'=>$today],
    			['area_name'=>'NORTHERN CEBU','area_code'=>'','salesman_name'=>'TANGYAN, CALIXTO','salesman_code'=>'A08','jr_salesman_name'=>'LUNISA, GELLYN','created_at'=>$today,'updated_at'=>$today],
    			['area_name'=>'SOUTHERN CEBU','area_code'=>'','salesman_name'=>'VARELA, MANUEL','salesman_code'=>'A13','jr_salesman_name'=>null,'created_at'=>$today,'updated_at'=>$today],
    			['area_name'=>'NORTHERN CEBU','area_code'=>'','salesman_name'=>'VICTORILLO, MARIANO JR.','salesman_code'=>'A15','jr_salesman_name'=>null,'created_at'=>$today,'updated_at'=>$today],
    			['area_name'=>'SFI BACOLOD','area_code'=>'300','salesman_name'=>'ERILLO, RODOLFO','salesman_code'=>'C02','jr_salesman_name'=>null,'created_at'=>$today,'updated_at'=>$today],
    			['area_name'=>'SFI DUMAGUETE','area_code'=>'700','salesman_name'=>'GRACIA, ELMER','salesman_code'=>'G02','jr_salesman_name'=>'','created_at'=>$today,'updated_at'=>$today],
    			['area_name'=>'ILOILO','area_code'=>'2900','salesman_name'=>'ARGUELLES, CARLO','salesman_code'=>'I02','jr_salesman_name'=>'','created_at'=>$today,'updated_at'=>$today],
    			['area_name'=>'ILOILO','area_code'=>'2900','salesman_name'=>'ABRECE, ALVIN','salesman_code'=>'I04','jr_salesman_name'=>'','created_at'=>$today,'updated_at'=>$today],
    			['area_name'=>'ILOILO','area_code'=>'2900','salesman_name'=>'TINGUBAN, ALFER','salesman_code'=>'I05','jr_salesman_name'=>'','created_at'=>$today,'updated_at'=>$today],
    			['area_name'=>'MASBATE','area_code'=>'','salesman_name'=>'ALBA, IÑIGO','salesman_code'=>'L06','jr_salesman_name'=>'','created_at'=>$today,'updated_at'=>$today],
    			['area_name'=>'ORMOC','area_code'=>'3400','salesman_name'=>'SENILLO, CHRISTIAN','salesman_code'=>'L07','jr_salesman_name'=>'','created_at'=>$today,'updated_at'=>$today],
    			['area_name'=>'ORMOC','area_code'=>'3400','salesman_name'=>'SIOC, JHUMBAR','salesman_code'=>'L08','jr_salesman_name'=>'','created_at'=>$today,'updated_at'=>$today],
    			['area_name'=>'ORMOC','area_code'=>'3400','salesman_name'=>'PAME, MANOLO JR.','salesman_code'=>'L09','jr_salesman_name'=>'','created_at'=>$today,'updated_at'=>$today],
    			['area_name'=>'BUTUAN','area_code'=>'2400','salesman_name'=>'MOLIG, RYAN','salesman_code'=>'D04','jr_salesman_name'=>'','created_at'=>$today,'updated_at'=>$today],
    			['area_name'=>'BUTUAN','area_code'=>'2400','salesman_name'=>'PUSPUS, KENNETH JOHN','salesman_code'=>'D02','jr_salesman_name'=>'','created_at'=>$today,'updated_at'=>$today],    			
    			['area_name'=>'CAGAYAN','area_code'=>'2500','salesman_name'=>'BECAGAS, GEOVANI','salesman_code'=>'E06','jr_salesman_name'=>'','created_at'=>$today,'updated_at'=>$today],
    			['area_name'=>'CAGAYAN','area_code'=>'2500','salesman_name'=>'DIAZ, MARK ALLEN','salesman_code'=>'E03','jr_salesman_name'=>'','created_at'=>$today,'updated_at'=>$today],
    			['area_name'=>'CAGAYAN','area_code'=>'2500','salesman_name'=>'BUHAWE, ARGIE JADE','salesman_code'=>'E07','jr_salesman_name'=>'','created_at'=>$today,'updated_at'=>$today],
    			['area_name'=>'OZAMIS','area_code'=>'3100','salesman_name'=>'SALAZAR, JONEE','salesman_code'=>'K04','jr_salesman_name'=>'LABRADOR, DIAJAN','created_at'=>$today,'updated_at'=>$today],
    			['area_name'=>'OZAMIS','area_code'=>'3100','salesman_name'=>'GODORNES, NARCISO','salesman_code'=>'K02','jr_salesman_name'=>'','created_at'=>$today,'updated_at'=>$today],
    			['area_name'=>'OZAMIS','area_code'=>'3100','salesman_name'=>'LUNA, RONNEL','salesman_code'=>'M03','jr_salesman_name'=>'','created_at'=>$today,'updated_at'=>$today],
    			['area_name'=>'DAVAO','area_code'=>'2600','salesman_name'=>'LIQUIT, IAN GLENN','salesman_code'=>'F02','jr_salesman_name'=>'RABE, VAL JOSEPH','created_at'=>$today,'updated_at'=>$today],
    			['area_name'=>'DAVAO','area_code'=>'2600','salesman_name'=>'JIMENEZ, EDWIN','salesman_code'=>'F11','jr_salesman_name'=>'','created_at'=>$today,'updated_at'=>$today],
    			['area_name'=>'DAVAO','area_code'=>'2600','salesman_name'=>'LOZANO, RELAN','salesman_code'=>'F05','jr_salesman_name'=>'BORDADO, JESREL','created_at'=>$today,'updated_at'=>$today],
    			['area_name'=>'DAVAO','area_code'=>'2600','salesman_name'=>'BERINGUEL, ALFE','salesman_code'=>'F06','jr_salesman_name'=>'','created_at'=>$today,'updated_at'=>$today],
    			['area_name'=>'DAVAO','area_code'=>'2600','salesman_name'=>'SILVA, JEOVANNI','salesman_code'=>'F03','jr_salesman_name'=>'JAY YOSURES','created_at'=>$today,'updated_at'=>$today],
    			['area_name'=>'GENERAL SANTOS','area_code'=>'2800','salesman_name'=>'RODRIGUEZ, RAYMOND','salesman_code'=>'H02','jr_salesman_name'=>'DAGANG, JULIAN','created_at'=>$today,'updated_at'=>$today],
    			['area_name'=>'GENERAL SANTOS','area_code'=>'2800','salesman_name'=>'SIAWAN, EVENREY','salesman_code'=>'H05','jr_salesman_name'=>'LLORENTE, RONNIE','created_at'=>$today,'updated_at'=>$today],
    			
    			
    			['area_name'=>'','area_code'=>'','salesman_name'=>'LOPEZ, RONNIE','salesman_code'=>'C06','jr_salesman_name'=>'','created_at'=>$today,'updated_at'=>$today],
    			['area_name'=>'','area_code'=>'','salesman_name'=>'ZAMORA, GELO','salesman_code'=>'E09','jr_salesman_name'=>'','created_at'=>$today,'updated_at'=>$today],
    			['area_name'=>'','area_code'=>'','salesman_name'=>'LICAYAN, ROBERTO ','salesman_code'=>'D08','jr_salesman_name'=>'','created_at'=>$today,'updated_at'=>$today],
    			
    	];
    	\DB::table('rds_salesman')->insert($salesman);
    }
}
