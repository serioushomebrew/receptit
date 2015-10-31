# API

## Products
search on terms<br>
GET: https://frahmework.ah.nl/ah/json/producten?productomschrijving=TERM&personalkey=API_KEY
```json
[
    {
        httpstatus: "200",
        querystatus: "1",
        nasanr: "1",
        webid: "120368",
        eannr: "8710400001812",
        merknaam: "AH",
        productomschrijving: "Macaroni vlugkokend",
        schapstickeromschrijving: "ah macaroni vlugkokend",
        inhoud: "500 GR",
        promotietekst: "Macaroni met een fijne, zachte bite en lekker vlug klaar!",
        recepttrefwoord: "macaroni",
        weergaveprionr: "1",
        producttags: "hoofdgerecht | pasta | macaroni | neutraal",
        keuken: "italiaans",
        gelegenheid: "",
        assortimentsgroepnr: "23",
        assortimentsgroepoms: "pasta",
        associatiegroepnr: "10",
        associatiegroepomschrijving: "Pasta, rijst, internationale keuken",
        wagnr: "19",
        wagomschrijving: "kruidenierswaren houdbaar",
        pkgbkeuze: "huismerk",
        poplevel: "7",
        inpresentatievanaf: "100",
        huidigevoorraad: "10",
        asskode: "A",
        inasssinds: "15-10-2012",
        uitassper: "",
        basisprijs: "0.64",
        lokaleprijs: "",
        bonusindicatie: "nee",
        pakketnr: "",
        pakketomschrijving: "",
        drempelaantal: "",
        bedragbeloning: "",
        percentagebeloning: "",
        vasteprijs: "",
        couponnr: "",
        aantalairmiles: "",
        einddatumverlenging: "",
        volgendelevering: "27-10-2015 16:35",
        tht: "21-12-2015",
        tusindicatie: "nee",
        ingredienten: "durum tarwegriesmeel (gluten), tarwebloem (gluten).",
        bereidingswijze: "
        1. Reken ca. 80 gram macaroni per persoon. 
        2. Breng in een ruime pan per 100 gram macaroni 1 liter water aan de kook. 
        Voeg een scheutje olijfolie toe.
        3. Laat de pasta in het water glijden en breng het water, onder af en toe roeren, opnieuw aan 
        de kook. 
        4. Kook de macaroni in 8 minuten zachtjes gaar. Regelmatig roeren. 
        Kook 7 minuten voor wat stevigere (alDente) macaroni. 
        5. Giet af in een vergiet en serveer direct.",
        voedingsclaim: "Een portie macaroni (80 g) bevat 280 kcal.",
        allergieclaim: "tarwe (gluten).",
        bewaaradvies: "Droog bewaren.",
        calorien: "355 kcal",
        joule: "1495 kJ",
        vetten: "1.5 g",
        verzadigd: "0.1 g",
        enkelv: "0.1 g",
        meerv: "1.5 g",
        koolhydr: "73 g",
        suikers: "3.5 g",
        vezels: "2.5 g",
        eiwitten: "11 g",
        webpafbeelding: "https://frahmework.ah.nl/!data/nasanr/1.webp",
        pngafbeelding: "https://frahmework.ah.nl/data/nasanr/png200/1.png",
        alternatievenurl: "https://frahmework.ah.nl/ah/json/producten?
        producttags=hoofdgerecht|pasta|neutraal"
    }, etc.
]
```


## Recipes
search on ingredients<br>
GET: https://frahmework.ah.nl/ah/json/recepten?receptomschrijving=TERM&personalkey=API_KEY
```json
[
    {
        httpstatus: "200",
        querystatus: "1",
        receptid: "7618",
        recepttitel: "Aardbeien met mascarponecrème",
        receptgang: "",
        receptmoment: "ontbijt",
        receptkooktechniek: "",
        receptseizoen: "zomer",
        receptgelegenheid: "pasen",
        receptsoort: "",
        receptkindertags: "",
        receptvleesvisofvega: "vegetarisch",
        receptallergeneninfo: "",
        receptkeuken: "italiaans",
        receptpersonen: "4",
        receptserveertype: "personen",
        receptbereidingswijze: "Haal de kroontjes van de aardbeien en halveer. Snijd de aardbeien in 
        dikke plakjes en spreid uit over een lage schaal. Klop met een mixer de mascarpone, kwark en 
        vanillesuiker tot een cr??me. Verdeel de mascarponecr??me over de aardbeien. 
        Breng in een kleine steelpan de boter en bruine suiker al roerend aan de kook. 
        Giet het suiker-botermengsel over de mascarponecr??me. Zet afgedekt ca. 1 uur in de 
        koelkast.",
        receptbereidingstijd: "10",
        receptbereidingsduurtekst: "10 min. bereiden 1 uur wachten",
        receptingredienten: "300 g aardbeien - 100 g mascarpone (zachte roomkaas) - 5 el volle kwark 
        - 16 g vanillesuiker (zakje à 8 g) - 20 g roomboter - 20 g donkerbruine basterdsuiker ",
        receptzoektermen: "aardbeien | mascarpone | vollekwark | vanillesuiker | roomboter | 
        donkerbruinebasterdsuiker",
        receptkeukenspullen: "",
        receptenergie: "240 kcal",
        receptkoolhydraten: "15 g",
        recepteiwitten: "4 g",
        receptvetten: "18 g",
        receptvetverzadigd: "0 g",
        receptnatrium: "",
        receptvezels: "",
        receptbron: "AllerHande april 2000",
        receptafbeelding: "https://frahmework.ah.nl/data/recepten/jpg200/FRAL0004115_200.jpg",
        recepturl: "http://www.ah.nl/allerhande/recept/R-R7618/aardbeien-met-mascarponecreme",
        recepttags: "ontbijt | pasen | vegetarisch | italiaans",
        productenurl: "https://frahmework.ah.nl/ah/json/producten?
        recepttags=aardbeien|mascarpone|vollekwark|vanillesuiker|roomboter|donkerbruinebasterdsuiker
        &weergaveprionr=1"
    }, etc.
]
```