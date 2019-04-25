<?php
function getStatistics() {
	$allTptp = TariffProviderTariffMatch::groupBy("user_id")
        ->join("users", "users.id", "tariff_provider_tariff_matches.user_id")
        ->selectRaw("CONCAT(first_name, ' ', last_name) as name, " .
            "SUM(CASE WHEN active_status=1 THEN 1 ELSE 0 END) AS valid, " .
            "SUM(CASE WHEN active_status=2 THEN 1 ELSE 0 END) AS pending, " .
            "SUM(CASE WHEN active_status=3 THEN 1 ELSE 0 END) AS invalid, " .
            "COUNT(active_status) AS total")
        ->get();

    // $cash = 40;
    $cash = floatval(GlobalVariable::getById(GlobalVariable::STANDARDIZATION_UNIT_PRICE)->value);

    $allTptp->each(function ($tptp) use ($cash){
        $tptp->cash = number_format($tptp->valid * $cash, 2);
    });

    return (["users" => $allTptp->toArray()]);
}