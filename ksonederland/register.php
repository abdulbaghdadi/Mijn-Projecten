<?php
// Include the database connection file
require_once 'connectie.php';

// Functie om wachtwoord te hashen
function hashWachtwoord($wachtwoord) {
    return password_hash($wachtwoord, PASSWORD_DEFAULT);
}

// Als het formulier is ingediend
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Gegevens ophalen uit het formulier
    $Bedrijfsnaam = $_POST['Bedrijfsnaam'];
    $sectorCode = $_POST['sector'];
    $categorieId = !empty($_POST['categorie']) ? $_POST['categorie'] : NULL;
    $Voornaam = $_POST['Voornaam'];
    $Achternaam = $_POST['Achternaam'];
    $telefoon = $_POST['telefoon'];
    $email = $_POST['email'];
    $wachtwoord = hashWachtwoord($_POST['wachtwoord']);

    // SQL-query voor het toevoegen van een nieuwe gebruiker
    $sql = "INSERT INTO gebruiker (Bedrijfsnaam, sector, categorie, Voornaam, Achternaam, telefoon, Emailadres, Wachtwoord) VALUES (:bedrijfsnaam, :sector, :categorieId, :voornaam, :achternaam, :telefoon, :email, :wachtwoord)";
    $stmt = $pdo->prepare($sql);

    // Bind parameters aan de query
    $stmt->bindParam(':bedrijfsnaam', $Bedrijfsnaam);
    $stmt->bindParam(':sector', $sectorCode);
    $stmt->bindParam(':categorieId', $categorieId, PDO::PARAM_INT);
    $stmt->bindParam(':voornaam', $Voornaam);
    $stmt->bindParam(':achternaam', $Achternaam);
    $stmt->bindParam(':telefoon', $telefoon);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':wachtwoord', $wachtwoord);

    // Probeer de gebruiker toe te voegen aan de database
    try {
        $stmt->execute();
        
        // Now, insert the sector code and its description into another_table
        $sectorOmschrijving = $_POST['sector_omschrijving'];
        $insertSql = "INSERT INTO sbi_code (code_id, omschrijving) VALUES (:sectorCode, :sectorOmschrijving)";
        $insertStmt = $pdo->prepare($insertSql);
        $insertStmt->bindParam(':sectorCode', $sectorCode);
        $insertStmt->bindParam(':sectorOmschrijving', $sectorOmschrijving);
        $insertStmt->execute();

        header('Location: index.php');

    } catch (PDOException $e) {
        die("Registratie mislukt: " . $e->getMessage());
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="register_Style.css">
    <title>Registreren</title>
</head>

<body>
<div class="login-box">
    <h2>Registreren</h2>
    <form method="post">
      
      <div class="user-box">
        <label for="Bedrijfsnaam"></label><br>
        <label>Bedrijfsnaam:</label>
        <input type="text" id="Bedrijfsnaam" name="Bedrijfsnaam" required><br>
        
      </div>

      <div class="user-box">
    <label for="sector">Sector:</label>
    <select id="sector" name="sector" required>
        <option value="">Selecteer een sector</option>
        <option value="011">011 - Teelt van eenjarige gewassen</option>
        <option value="012">012 - Teelt van meerjarige gewassen</option>
        <option value="013">013 - Teelt van sierplanten en –bomen en bloembollen</option>
        <option value="014">014 - Fokken en houden van dieren</option>
        <option value="015">015 - Akker- en/of tuinbouw in combinatie met het fokken en houden van dieren</option>
        <option value="016">016 - Dienstverlening voor de landbouw; behandeling van gewassen na de oogst</option>
        <option value="017">017 - Jacht</option>
        <option value="021">021 - Bosbouw</option>
        <option value="022">022 - Exploitatie van bossen</option>
        <option value="024">024 - Dienstverlening voor de bosbouw</option>
        <option value="031">031 - Visserij</option>
        <option value="032">032 - Kweken van vis en schaaldieren</option>
        <option value="061">061 - Winning van aardolie</option>
        <option value="062">062 - Winning van aardgas</option>
        <option value="081">081 - Winning van zand, grind en klei</option>
        <option value="089">089 - Winning van overige delfstoffen</option>
        <option value="091">091 - Dienstverlening voor de winning van aardolie- en aardgas</option>
        <option value="099">099 - Dienstverlening voor de winning van delfstoffen (geen olie en gas)</option>
        <option value="101">101 - Slachterijen en vleesverwerking</option>
        <option value="102">102 - Visverwerking</option>
        <option value="103">103 - Verwerking van aardappels, groente en fruit</option>
        <option value="104">104 - Vervaardiging van plantaardige en dierlijke oliën en vetten</option>
        <option value="105">105 - Vervaardiging van zuivelproducten</option>
        <option value="106">106 - Vervaardiging van meel</option>
        <option value="107">107 - Vervaardiging van brood, vers banketbakkerswerk en deegwaren</option>
        <option value="108">108 - Vervaardiging van overige voedingsmiddelen</option>
        <option value="109">109 - Vervaardiging van diervoeders</option>
        <option value="110">110 - Vervaardiging van dranken</option>
        <option value="120">120 - Vervaardiging van tabaksproducten</option>
        <option value="131">131 - Bewerken en spinnen van textielvezels</option>
        <option value="132">132 - Weven van textiel</option>
        <option value="133">133 - Textielveredeling</option>
        <option value="139">139 - Vervaardiging van overige textielproducten</option>
        <option value="141">141 - Vervaardiging van kleding (geen bontkleding)</option>
        <option value="142">142 - Vervaardiging van artikelen van bont</option>
        <option value="143">143 - Vervaardiging van gebreide en gehaakte kleding</option>
        <option value="151">151 - Looien en bewerken van leer; vervaardiging van koffers, tassen, zadel- en tuigmakerswerk; bereiden en verven van bont</option>
        <option value="152">152 - Vervaardiging van schoenen</option>
        <option value="161">161 - Primaire houtbewerking en verduurzamen van hout</option>
        <option value="162">162 - Vervaardiging van artikelen van hout, kurk, riet en vlechtwerk (geen meubels)</option>
        <option value="171">171 - Vervaardiging van papierpulp, papier en karton</option>
        <option value="172">172 - Vervaardiging van papier- en kartonwaren</option>
        <option value="181">181 - Drukkerijen en dienstverlening voor drukkerijen</option>
        <option value="182">182 - Reproductie van opgenomen media</option>
        <option value="191">191 - Vervaardiging van cokesovenproducten</option>
        <option value="192">192 - Aardolieverwerking</option>
        <option value="201">201 - Vervaardiging van chemische basisproducten, kunstmeststoffen en stikstofverbindingen en van kunststof en synthetische rubber in primaire vorm</option>
        <option value="202">202 - Vervaardiging van verdelgingsmiddelen en overige landbouwchemicaliën</option>
        <option value="203">203 - Vervaardiging van verf, vernis e.d., drukinkt en mastiek</option>
        <option value="204">204 - Vervaardiging van zeep, wasmiddelen, poets- en reinigingsmiddelen, parfums en cosmetica</option>
        <option value="205">205 - Vervaardiging van overige chemische producten</option>
        <option value="206">206 - Vervaardiging van synthetische en kunstmatige vezels</option>
        <option value="211">211 - Vervaardiging van farmaceutische grondstoffen</option>
        <option value="212">212 - Vervaardiging van farmaceutische producten (geen grondstoffen)</option>
        <option value="221">221 - Vervaardiging van producten van rubber</option>
        <option value="222">222 - Vervaardiging van producten van kunststof</option>
        <option value="231">231 - Vervaardiging van glas en glaswerk</option>
        <option value="232">232 - Vervaardiging van vuurvaste keramische producten</option>
        <option value="233">233 - Vervaardiging van producten van klei voor de bouw</option>
        <option value="234">234 - Vervaardiging van overige keramische producten</option>
        <option value="235">235 - Vervaardiging van cement, kalk en gips</option>
        <option value="236">236 - Vervaardiging van producten van beton, gips en cement</option>
        <option value="237">237 - Natuursteenbewerking</option>
        <option value="239">239 - Vervaardiging van overige niet-metaalhoudende minerale producten</option>
        <option value="241">241 - Vervaardiging van ijzer en staal en van ferrolegeringen</option>
        <option value="242">242 - Vervaardiging van stalen buizen, pijpen, holle profielen en fittings daarvoor</option>
        <option value="243">243 - Overige eerste verwerking van staal</option>
        <option value="244">244 - Vervaardiging van edelmetalen en overige non-ferrometalen</option>
        <option value="245">245 - Gieten van metalen</option>
        <option value="251">251 - Vervaardiging van metalen producten voor de bouw</option>
        <option value="252">252 - Vervaardiging van reservoirs van metaal en van ketels en radiatoren voor centrale verwarming</option>
        <option value="253">253 - Vervaardiging van stoomketels (geen ketels voor centrale verwarming)</option>
        <option value="254">254 - Vervaardiging van wapens en munitie</option>
        <option value="255">255 - Smeden, persen, stampen en profielwalsen van metaal; poedermetallurgie</option>
        <option value="256">256 - Oppervlaktebehandeling en bekleding van metaal; algemene metaalbewerking</option>
        <option value="257">257 - Vervaardiging van scharen, messen en bestek, hang- en sluitwerk en gereedschap</option>
        <option value="259">259 - Vervaardiging van overige producten van metaal</option>
        <option value="261">261 - Vervaardiging van elektronische componenten en printplaten</option>
        <option value="262">262 - Vervaardiging van computers en randapparatuur</option>
        <option value="263">263 - Vervaardiging van communicatieapparatuur</option>
        <option value="264">264 - Vervaardiging van consumentenelektronica</option>
        <option value="265">265 - Vervaardiging van meet-, regel-, navigatie- en controleapparatuur en van uurwerken</option>
        <option value="266">266 - Vervaardiging van bestralingsapparatuur en van elektromedische en elektrotherapeutische apparatuur</option>
        <option value="267">267 - Vervaardiging van optische instrumenten en apparatuur</option>
        <option value="268">268 - Vervaardiging van informatiedragers</option>
        <option value="271">271 - Vervaardiging van elektromotoren, elektrische generatoren en transformatoren en van apparatuur voor elektriciteitsdistributie en -controle</option>
        <option value="272">272 - Vervaardiging van batterijen en accumulators</option>
        <option value="273">273 - Vervaardiging van kabels en bedradingen</option>
        <option value="274">274 - Vervaardiging van elektrische verlichting</option>
        <option value="275">275 - Vervaardiging van huishoudelijke apparaten</option>
        <option value="279">279 - Vervaardiging van overige elektrische apparatuur</option>
        <option value="281">281 - Vervaardiging van machines voor de productie van mechanische energie</option>
        <option value="282">282 - Vervaardiging van overige machines en apparaten voor algemeen gebruik</option>
        <option value="283">283 - Vervaardiging van landbouw- en bosbouwmachines</option>
        <option value="284">284 - Vervaardiging van machines voor de metaalbewerking</option>
        <option value="289">289 - Vervaardiging van overige machines en apparaten voor specifieke doeleinden</option>
        <option value="291">291 - Vervaardiging van motorvoertuigen en motorvoertuigonderdelen</option>
        <option value="292">292 - Vervaardiging van carrosserieën voor motorvoertuigen; vervaardiging van aanhangwagens en opleggers</option>
        <option value="293">293 - Vervaardiging van onderdelen en toebehoren voor motorvoertuigen</option>
        <option value="301">301 - Scheepsbouw</option>
        <option value="302">302 - Vervaardiging van spoorwegmaterieel</option>
        <option value="303">303 - Vervaardiging van lucht- en ruimtevaartuigen</option>
        <option value="304">304 - Vervaardiging van militaire gevechtsvoertuigen</option>
        <option value="309">309 - Vervaardiging van vervoermiddelen n.e.g.</option>
        <option value="310">310 - Vervaardiging van meubels</option>
        <option value="321">321 - Vervaardiging van sieraden, bijouterieën en gerelateerde artikelen</option>
        <option value="322">322 - Vervaardiging van muziekinstrumenten</option>
        <option value="323">323 - Vervaardiging van sportartikelen</option>
        <option value="324">324 - Vervaardiging van spelletjes en speelgoed</option>
        <option value="325">325 - Vervaardiging van medische en tandheelkundige instrumenten en benodigdheden</option>
        <option value="329">329 - Vervaardiging van overige producten n.e.g.</option>
        <option value="331">331 - Reparatie en installatie van machines voor algemeen gebruik</option>
        <option value="332">332 - Reparatie van machines en apparaten voor industriële productie</option>
        <option value="333">333 - Reparatie en installatie van machines voor specifieke doeleinden</option>
        <option value="351">351 - Productie en distributie van elektriciteit</option>
        <option value="352">352 - Productie en distributie van gas</option>
        <option value="353">353 - Distributie van warmte</option>
        <option value="360">360 - Winning en distributie van water</option>
        <option value="370">370 - Zuivering en distributie van water</option>
        <option value="381">381 - Afvalinzameling</option>
        <option value="382">382 - Afvalverwerking</option>
        <option value="383">383 - Herwinning van afval</option>
        <option value="390">390 - Overige afvalbeheeractiviteiten</option>
        <option value="411">411 - Projectontwikkeling</option>
        <option value="412">412 - Bouw van gebouwen</option>
        <option value="421">421 - Bouw van wegen en spoorwegen</option>
        <option value="422">422 - Bouw van bruggen en tunnels</option>
        <option value="429">429 - Bouw van waterbouwkundige werken</option>
        <option value="431">431 - Sloop- en grondwerk</option>
        <option value="432">432 - Installatie van elektrische en elektronische apparaten</option>
        <option value="433">433 - Afwerking van gebouwen</option>
        <option value="439">439 - Overige gespecialiseerde werkzaamheden in de bouw</option>
        <option value="451">451 - Handel in en reparatie van auto's, motorfietsen en aanhangwagens</option>
        <option value="452">452 - Reparatie en onderhoud van auto's</option>
        <option value="453">453 - Handel in en reparatie van onderdelen en accessoires van auto's en motorfietsen</option>
        <option value="454">454 - Handel in en reparatie van motorfietsen en onderdelen</option>
        <option value="461">461 - Commissiehandel en handelsbemiddeling in agrarische grondstoffen, levende dieren, textielgrondstoffen en halffabrikaten</option>
        <option value="462">462 - Groothandel in landbouwproducten en levende dieren</option>
        <option value="463">463 - Groothandel in voedings- en genotmiddelen</option>
        <option value="464">464 - Groothandel in huishoudelijke artikelen</option>
        <option value="465">465 - Groothandel in elektronische en telecommunicatie-apparatuur en toebehoren</option>
        <option value="466">466 - Groothandel in andere machines, apparaten en toebehoren</option>
        <option value="467">467 - Groothandel in brandstoffen en metalen</option>
        <option value="469">469 - Groothandel in overige producten n.e.g.</option>
        <option value="471">471 - Detailhandel in niet-gespecialiseerde winkels</option>
        <option value="472">472 - Detailhandel in voedingsmiddelen</option>
        <option value="473">473 - Detailhandel in brandstoffen</option>
        <option value="474">474 - Detailhandel in computers, randapparatuur en software</option>
        <option value="475">475 - Detailhandel in overige consumentenartikelen</option>
        <option value="476">476 - Detailhandel in cultuur- en recreatie-artikelen</option>
        <option value="477">477 - Detailhandel in andere nieuwe goederen</option>
        <option value="478">478 - Detailhandel via markten</option>
        <option value="479">479 - Detailhandel niet in winkels of op markten</option>
        <option value="491">491 - Personenvervoer per spoor</option>
        <option value="492">492 - Goederenvervoer per spoor</option>
        <option value="493">493 - Personenvervoer per bus</option>
        <option value="494">494 - Goederenvervoer over de weg</option>
        <option value="495">495 - Pijpleidingvervoer</option>
        <option value="501">501 - Zee- en kustvaart</option>
        <option value="502">502 - Binnenvaart</option>
        <option value="503">503 - Vervoer per kabelbaan</option>
        <option value="504">504 - Vervoer per ruimtevaartuig</option>
        <option value="511">511 - Luchtvervoer van passagiers</option>
        <option value="512">512 - Luchtvrachtvervoer</option>
        <option value="521">521 - Opslag in distributiecentra en andere opslag</option>
        <option value="522">522 - Dienstverlening voor vervoer</option>
        <option value="531">531 - Postdiensten</option>
        <option value="532">532 - Koeriersdiensten</option>
        <option value="551">551 - Hotels</option>
        <option value="552">552 - Vakantiehuisjes en -appartementen</option>
        <option value="553">553 - Kampeerterreinen en kampeerplaatsen</option>
        <option value="559">559 - Overige accommodatie</option>
        <option value="561">561 - Restaurants</option>
        <option value="562">562 - Catering en overige dienstverlening</option>
        <option value="563">563 - Cafés en andere drinkgelegenheden</option>
        <option value="581">581 - Uitgeven van boeken, tijdschriften en overige periodieken</option>
        <option value="582">582 - Uitgeven van software</option>
        <option value="591">591 - Productie van films en televisieprogramma's</option>
        <option value="592">592 - Vervaardiging van geluidsopnamen en muziekuitgeverijen</option>
        <option value="601">601 - Radio-omroep</option>
        <option value="602">602 - Televisieomroep</option>
        <option value="611">611 - Telegrafie</option>
        <option value="612">612 - Telefoon- en mobiele telefoonverkeer</option>
        <option value="613">613 - Telecommunicatie via satellieten</option>
        <option value="619">619 - Overige telecommunicatieactiviteiten</option>
        <option value="620">620 - Informatietechnologie- en computerdiensten</option>
        <option value="631">631 - Gegevensverwerking, webhosting en gerelateerde activiteiten</option>
        <option value="639">639 - Overige informatieactiviteiten</option>
        <option value="641">641 - Banken</option>
        <option value="642">642 - Beleggingsmaatschappijen en financiële holdings</option>
        <option value="643">643 - Beleggingsfondsen</option>
        <option value="649">649 - Overige financiële instellingen (geen verzekeringen en pensioenfondsen)</option>
        <option value="651">651 - Verzekeringen</option>
        <option value="652">652 - Herverzekeringen</option>
        <option value="653">653 - Beheer van pensioenfondsen</option>
        <option value="661">661 - Dienstverlening voor het verzekeringswezen en pensioenfondsen</option>
        <option value="662">662 - Risicoanalisten en verzekeringsmakelaars</option>
        <option value="663">663 - Beheer van beleggingsfondsen</option>
        <option value="681">681 - Vastgoed</option>
        <option value="682">682 - Bemiddeling bij koop en verkoop van onroerend goed</option>
        <option value="683">683 - Beheer van onroerend goed</option>
        <option value="691">691 - Rechtskundig advies</option>
        <option value="692">692 - Boekhoudkundige en administratieve dienstverlening</option>
        <option value="701">701 - Public relations en communicatie</option>
        <option value="702">702 - Adviesbureaus</option>
        <option value="711">711 - Architecten en ingenieurs</option>
        <option value="712">712 - Technische proef- en analysebureaus</option>
        <option value="721">721 - Onderzoek en ontwikkeling op natuurwetenschappelijk gebied</option>
        <option value="722">722 - Onderzoek en ontwikkeling op maatschappelijk en geesteswetenschappelijk gebied</option>
        <option value="731">731 - Reclamebureaus</option>
        <option value="732">732 - Marktonderzoekbureaus</option>
        <option value="741">741 - Ontwerpers</option>
        <option value="742">742 - Fotografen</option>
        <option value="743">743 - Vertalers en tolken</option>
        <option value="749">749 - Overige zakelijke dienstverlening</option>
        <option value="750">750 - Dierenartsen</option>
        <option value="771">771 - Verhuur en lease van auto's</option>
        <option value="772">772 - Verhuur van consumentenartikelen</option>
        <option value="773">773 - Verhuur en lease van machines en installaties</option>
        <option value="774">774 - Verhuur en lease van onroerend goed</option>
        <option value="781">781 - Arbeidsbemiddeling</option>
        <option value="782">782 - Uitzendbureaus</option>
        <option value="783">783 - Payrolling</option>
        <option value="791">791 - Reisbureaus</option>
        <option value="792">792 - Reisorganisatoren</option>
        <option value="799">799 - Overige reisorganisatie</option>
        <option value="801">801 - Beveiliging</option>
        <option value="802">802 - Opsporing</option>
        <option value="811">811 - Facilitaire bedrijven</option>
        <option value="812">812 - Schoonmaak</option>
        <option value="813">813 - Landschapsverzorging</option>
        <option value="821">821 - Callcenters</option>
        <option value="822">822 - Secretariaats- en vertaalbureaus</option>
        <option value="823">823 - Organisatie van congressen en beurzen</option>
        <option value="829">829 - Overige zakelijke dienstverlening n.e.g.</option>
        <option value="841">841 - Openbaar bestuur en overheidsdiensten</option>
        <option value="842">842 - Belasting- en douanezaken</option>
        <option value="843">843 - Sociale verzekeringen</option>
        <option value="851">851 - Primair en speciaal onderwijs</option>
        <option value="852">852 - Voortgezet onderwijs</option>
        <option value="853">853 - Hoger beroepsonderwijs</option>
        <option value="854">854 - Universitair onderwijs</option>
        <option value="855">855 - Overige onderwijs</option>
        <option value="861">861 - Ziekenhuizen</option>
        <option value="862">862 - Verpleging, verzorging en overig ziekenhuisverpleging</option>
        <option value="869">869 - Gezondheidszorg n.e.g.</option>
        <option value="871">871 - Verpleeghuizen</option>
        <option value="872">872 - Jeugdzorg</option>
        <option value="873">873 - Gehandicaptenzorg</option>
        <option value="879">879 - Overige zorg</option>
        <option value="881">881 - Maatschappelijk werk</option>
        <option value="889">889 - Overige maatschappelijke dienstverlening</option>
        <option value="891">891 - Arbeidsbegeleiding en –integratie</option>
        <option value="900">900 - Kunst</option>
        <option value="910">910 - Musea</option>
        <option value="920">920 - Kansspelen en loterijen</option>
        <option value="931">931 - Sport</option>
        <option value="932">932 - Overige recreatie</option>
        <option value="941">941 - Werkgeversorganisaties</option>
        <option value="942">942 - Werknemersorganisaties</option>
        <option value="949">949 - Overige belangen- en ideële organisaties</option>
        <option value="951">951 - Reparatie van computers</option>
        <option value="952">952 - Reparatie van overige consumentenartikelen</option>
        <option value="960">960 - Dienstverlening n.e.g.</option>
    </select>
</div>

      <!-- Hidden input field for sector omschrijving -->
      <input type="hidden" id="sector_omschrijving" name="sector_omschrijving">
      <div class="user-box">
        <label for="categorie">Categorie:</label>
        <select id="categorie" name="categorie">
            <option value=""></option>
            <?php
            try {
                // Prepare and execute the SQL query to select categories
                $sql = "SELECT * FROM categorie";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();

                // Generate options for categories
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $categoryId = $row['categorie_id'];
                    $categoryName = $row['naam'];
                    echo "<option value='$categoryId'>$categoryName</option>";
                }
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            ?>
        </select>
        
      </div>


      <div class="user-box">
        <label for="Voornaam"></label><br>  
              <label>Voornaam:</label>
        <input type="text" id="Voornaam" name="Voornaam" required><br>
      </div>

      <div class="user-box">
        <label for="Achternaam"></label><br>
        <label>Achternaam:</label>
        <input type="text" id="Achternaam" name="Achternaam" required><br>
      </div>

      <div class="user-box">
        <label for="telefoon"></label><br>
          <label>Telefoon:</label>
        <input type="text" id="telefoon" name="telefoon" required><br>
      </div>

      <div class="user-box">
        <label for="email"></label><br>
        <label>Email:</label>
        <input type="email" id="email" name="email" required><br>
      </div>

      <div class="user-box">
        <label for="wachtwoord"></label><br>
        <label>Wachtwoord:</label>
        <input type="password" id="wachtwoord" name="wachtwoord" required><br>
      </div>

      <button type="submit" class="submit-button">
  Registreren

</button>

    </form>
</div>


</body>
</html>
