<?php
// Lista de URLs dos produtos
$urls = [
    'https://www.mercadolivre.com.br/leite-condensado-semidesnatado-italac-caixa-395g/p/MLB18308903?pdp_filters=item_id:MLB3626639199#is_advertising=true&searchVariation=MLB18308903&position=1&search_layout=stack&type=pad&tracking_id=259cf76e-a267-43fc-b625-24114a9ad0e9&is_advertising=true&ad_domain=VQCATCORE_LST&ad_position=1&ad_click_id=NGY4ZGRjODItNGVjYy00OTMzLWFlZDEtN2ZlZTM2ODdlODBm',
    'https://www.mercadolivre.com.br/granulado-macio-500g-dori/p/MLB19765650?pdp_filters=deal%3AMLB1020501-1%7Cshipping%3Afulfillment#polycard_client=search-nordic&wid=MLB3806678448&sid=search&searchVariation=MLB19765650&position=2&search_layout=grid&type=product&tracking_id=37d9492f-2eb0-484e-8b97-325130b4bb94',
    'https://www.mercadolivre.com.br/flocos-macio-escama-500g-mavalerio/p/MLB19765673#polycard_client=recommendations_home_navigation-recommendations&reco_backend=machinalis-homes-univb-equivalent-offer&wid=MLB3551713341&reco_client=home_navigation-recommendations&reco_item_pos=2&reco_backend_type=function&reco_id=830c6809-9268-4201-930f-58ece438808f&sid=recos&c_id=/home/navigation-recommendations/element&c_uid=4e2e6978-1f4a-4531-bdd0-c54130bc1d51',
    'https://produto.mercadolivre.com.br/MLB-3137507335-forminha-de-papel-branca-doce-brigadeiro-numero-5-c-1000un-_JM#polycard_client=search-nordic&position=14&search_layout=grid&type=item&tracking_id=6f509785-217a-404d-a5b9-283fa3441722',
    'https://produto.mercadolivre.com.br/MLB-3437503032-cacau-em-po-1kg-um-kg-natural-100-alcalino-receita-farinha-_JM?matt_tool=77817081&matt_word=&matt_source=google&matt_campaign_id=14302215744&matt_ad_group_id=125382907665&matt_match_type=&matt_network=g&matt_device=c&matt_creative=539491050659&matt_keyword=&matt_ad_position=&matt_ad_type=pla&matt_merchant_id=689098818&matt_product_id=MLB3437503032&matt_product_partition_id=1799626191510&matt_target_id=pla-1799626191510&cq_src=google_ads&cq_cmp=14302215744&cq_net=g&cq_plt=gp&cq_med=pla&gad_source=1&gclid=Cj0KCQiApNW6BhD5ARIsACmEbkWpI50Rdu3MopCig88qRqtBrtqVh-3MUgYmfF4UAcL-K14V0hFl7TUaAtClEALw_wcB',
    'https://www.mercadolivre.com.br/leite-po-integral-ninho-forti-lata-380g/p/MLB18382087?pdp_filters=item_id:MLB2033567661#is_advertising=true&searchVariation=MLB18382087&position=1&search_layout=stack&type=pad&tracking_id=ee23e3bd-1ee1-4edf-9bb8-f4a265999de7&is_advertising=true&ad_domain=VQCATCORE_LST&ad_position=1&ad_click_id=YmUzNDAwYzctZTgyNi00ZmY0LWJlOTItMDRlYjkyZmJlNTQy'
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36');
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Accept-Language: pt-BR,pt;q=0.9',
    'Referer: https://www.mercadolivre.com.br',
]);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);   
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);   

$results = [];

foreach ($urls as $url) {
    curl_setopt($ch, CURLOPT_URL, $url);
    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        $results[] = ['url' => $url, 'error' => curl_error($ch)];
        continue;
    }

    file_put_contents('debug_response.html', $response);

    $response = mb_convert_encoding($response, 'HTML-ENTITIES', 'UTF-8');
    $dom = new DOMDocument();
    libxml_use_internal_errors(true);
    $dom->loadHTML($response);
    libxml_clear_errors();

    $xpath = new DOMXPath($dom);

    $nameNode = $xpath->query("//h1[contains(@class, 'ui-pdp-title')]");
    $productName = $nameNode->length > 0 ? trim($nameNode->item(0)->textContent) : 'Nome não encontrado';

    $priceNodes = $xpath->query("//span[@data-testid='price-part']");
    $prices = [];

    foreach ($priceNodes as $priceNode) {
        $fractionNode = $xpath->query(".//span[@class='andes-money-amount__fraction']", $priceNode);
        $centsNode = $xpath->query(".//span[contains(@class, 'andes-money-amount__cents')]", $priceNode);

        if ($fractionNode->length > 0 && $centsNode->length > 0) {
            $fraction = trim($fractionNode->item(0)->textContent);
            $cents = trim($centsNode->item(0)->textContent);
            $price = floatval("$fraction.$cents");
            $prices[] = $price;
        }
    }

    if (!empty($prices)) {
        $minPrice = min($prices); 
        $results[] = [
            'url' => $url,
            'product_name' => $productName,
            'min_price' => 'R$ ' . number_format($minPrice, 2, ',', '.'),
        ];
    } else {
        $results[] = [
            'url' => $url,
            'product_name' => $productName,
            'error' => 'Preços não encontrados.',
        ];
    }
}

curl_close($ch);

header('Content-Type: application/json; charset=UTF-8');
echo json_encode($results, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
