const travelTypes = {
    first: {
        value: 'one way',
        text: 'One way'
    },
    second: {
        value: 'round trip',
        text: 'Round trip'
    },
};

const cabinClasses = {
    first: {
        value: 'economy',
        text: 'Economy'
    },
    second: {
        value: 'business',
        text: 'Business'
    },
};

const passengers = {
    first: {
        value: 'Infant (0 - 23 months)',
        text: 'Infant (0 - 23 months)'
    },
    second: {
        value: 'Child (2 - 11 years)',
        text: 'Child (2 - 11 years)'
    },
    third: {
        value: 'Youth (12 - 17 years)',
        text: 'Youth (12 - 17 years)'
    },
    fourth: {
        value: 'Adult',
        text: 'Adult'
    },
    fifth: {
        value: 'Senior (65 years and Older)',
        text: 'Senior (65 years and Older)'
    },
};

const countryCodes = [
    {
        text: 'Afghanistan (+93)',
        value: '+93'
    },
    {
        text: 'Albania (+355)',
        value: '+355'
    },
    {
        text: 'Algeria (+213)',
        value: '+213'
    },
    {
        text: 'American Samoa (+1-684)',
        value: '+1-684'
    },
    {
        text: 'Angola (+244)',
        value: '+244'
    },
    {
        text: 'Anguilla (+1-264)',
        value: '+1-264'
    },
    {
        text: 'Antarctica (+672)',
        value: '+672'
    },
    {
        text: 'Antigua and Barbuda (+1-268)',
        value: '+1-268'
    },
    {
        text: 'Argentina (+54)',
        value: '+54'
    },
    {
        text: 'Armenia (+374)',
        value: '+374'
    },
    {
        text: 'Aruba (+297)',
        value: '+297'
    },
    {
        text: 'Australia (+61)',
        value: '+61'
    },
    {
        text: 'Austria (+43)',
        value: '+43'
    },
    {
        text: 'Bahamas (+1-242)',
        value: '+1-242'
    },
    {
        text: 'Bahrain (+973)',
        value: '+973'
    },
    {
        text: 'Bangladesh (+880)',
        value: '+880'
    },
    {
        text: 'Barbados (+1-246)',
        value: '+1-246'
    },
    {
        text: 'Belarus (+375)',
        value: '+375'
    },
    {
        text: 'Belgium (+32)',
        value: '+32'
    },
    {
        text: 'Belize (+501)',
        value: '+501'
    },
    {
        text: 'Benin (+229)',
        value: '+229'
    },
    {
        text: 'Bermuda (+1-441)',
        value: '+1-441'
    },
    {
        text: 'Bhutan (+975)',
        value: '+975'
    },
    {
        text: 'Bolivia (+591)',
        value: '+591'
    },
    {
        text: 'Bosnia and Herzegovina (+387)',
        value: '+387'
    },
    {
        text: 'Botswana (+267)',
        value: '+267'
    },
    {
        text: 'Brazil (+55)',
        value: '+55'
    },
    {
        text: 'British Indian Ocean Territory (+246)',
        value: '+246'
    },
    {
        text: 'British Virgin Islands (+1-284)',
        value: '+1-284'
    },
    {
        text: 'Brunei (+673)',
        value: '+673'
    },
    {
        text: 'Bulgaria (+359)',
        value: '+359'
    },
    {
        text: 'Burkina Faso (+226)',
        value: '+226'
    },
    {
        text: 'Burundi (+257)',
        value: '+257'
    },
    {
        text: 'Cambodia (+855)',
        value: '+855'
    },
    {
        text: 'Cameroon (+237)',
        value: '+237'
    },
    {
        text: 'Canada (+1)',
        value: '+1'
    },
    {
        text: 'Cape Verde (+238)',
        value: '+238'
    },
    {
        text: 'Cayman Islands (+1-345)',
        value: '+1-345'
    },
    {
        text: 'Central African Republic (+236)',
        value: '+236'
    },
    {
        text: 'Chad (+235)',
        value: '+235'
    },
    {
        text: 'Chile (+56)',
        value: '+56'
    },
    {
        text: 'China (+86)',
        value: '+86'
    },
    {
        text: 'Christmas Island (+61)',
        value: '+61'
    },
    {
        text: 'Cocos Islands (+61)',
        value: '+61'
    },
    {
        text: 'Colombia (+57)',
        value: '+57'
    },
    {
        text: 'Comoros (+269)',
        value: '+269'
    },
    {
        text: 'Cook Islands (+)',
        value: '+682'
    },
    {
        text: 'Costa Rica (+506)',
        value: '+506'
    },
    {
        text: 'Croatia (+385)',
        value: '+385'
    },
    {
        text: 'Cuba (+53)',
        value: '+53'
    },
    {
        text: 'Curacao (+599)',
        value: '+599'
    },
    {
        text: 'Cyprus (+357)',
        value: '+357'
    },
    {
        text: 'Czech Republic (+420)',
        value: '+420'
    },
    {
        text: 'Democratic Republic of the Congo (+243)',
        value: '+243'
    },
    {
        text: 'Denmark (+45)',
        value: '+45'
    },
    {
        text: 'Djibouti (+253)',
        value: '+253'
    },
    {
        text: 'Dominica (+1-767)',
        value: '+1-767'
    },
    {
        text: 'Dominican Republic (+1-809)', //1-809, 1-829, 1-849
        value: '+1-809'
    },
    {
        text: 'East Timor (+670)',
        value: '+670'
    },
    {
        text: 'Ecuador (+593)',
        value: '+593'
    },
    {
        text: 'Egypt (+20)',
        value: '+20'
    },
    {
        text: 'El Salvador (+503)',
        value: '+503'
    },
    {
        text: 'Equatorial Guinea (+240)',
        value: '+376'
    },
    {
        text: 'Eritrea (+291)',
        value: '+291'
    },
    {
        text: 'Estonia (+372)',
        value: '+372'
    },
    {
        text: 'Ethiopia (+251)',
        value: '+251'
    },
    {
        text: 'Falkland Islands (+500)',
        value: '+500'
    },
    {
        text: 'Faroe Islands (+298)',
        value: '+298'
    },
    {
        text: 'Fiji (+679)',
        value: '+679'
    },
    {
        text: 'Finland (+358)',
        value: '+358'
    },
    {
        text: 'France (+33)',
        value: '+33'
    },
    {
        text: 'French Polynesia (+689)',
        value: '+689'
    },
    {
        text: 'Gabon (+241)',
        value: '+241'
    },
    {
        text: 'Gambia (+220)',
        value: '+220'
    },
    {
        text: 'Georgia (+995)',
        value: '+995'
    },
    {
        text: 'Germany (+49)',
        value: '+49'
    },
    {
        text: 'Ghana (+233)',
        value: '+233'
    },
    {
        text: 'Gibraltar (+350)',
        value: '+350'
    },
    {
        text: 'Greece (+30)',
        value: '+30'
    },
    {
        text: 'Greenland (+299)',
        value: '+299'
    },
    {
        text: 'Grenada (+1-473)',
        value: '+1-473'
    },
    {
        text: 'Guam (+1-671)',
        value: '+1-671'
    },
    {
        text: 'Guatemala (+502)',
        value: '+502'
    },
    {
        text: 'Guernsey (+44-1481)',
        value: '+44-1481'
    },
    {
        text: 'Guinea (+224)',
        value: '+224'
    },
    {
        text: 'Guinea-Bissau (+245)',
        value: '+245'
    },
    {
        text: 'Guyana (+592)',
        value: '+592'
    },
    {
        text: 'Haiti (+509)',
        value: '+509'
    },
    {
        text: 'Honduras (+504)',
        value: '+504'
    },
    {
        text: 'Hong Kong (+852)',
        value: '+852'
    },
    {
        text: 'Hungary (+36)',
        value: '+36'
    },
    {
        text: 'Iceland (+354)',
        value: '+354'
    },
    {
        text: 'India (+91)',
        value: '+91'
    },
    {
        text: 'Indonesia (+62)',
        value: '+62'
    },
    {
        text: 'Iran (+98)',
        value: '+98'
    },
    {
        text: 'Iraq (+964)',
        value: '+964'
    },
    {
        text: 'Ireland (+353)',
        value: '+353'
    },
    {
        text: 'Isle of Man (+44-1624)',
        value: '+44-1624'
    },
    {
        text: 'Israel (+972)',
        value: '+972'
    },
    {
        text: 'Italy (+39)',
        value: '+39'
    },
    {
        text: 'Ivory Coast (+225)',
        value: '+225'
    },
    {
        text: 'Jamaica (+1-876)',
        value: '+1-876'
    },
    {
        text: 'Japan (+81)',
        value: '+81'
    },
    {
        text: 'Jersey (+44-1534)',
        value: '+44-1534'
    },
    {
        text: 'Jordan (+962)',
        value: '+962'
    },
    {
        text: 'Kazakhstan (+7)',
        value: '+7'
    },
    {
        text: 'Kenya (+254)',
        value: '+254'
    },
    {
        text: 'Kiribati (+686)',
        value: '+686'
    },
    {
        text: 'Kosovo (+383)',
        value: '+383'
    },
    {
        text: 'Kuwait (+965)',
        value: '+965'
    },
    {
        text: 'Kyrgyzstan (+996)',
        value: '+996'
    },
    {
        text: 'Laos (+856)',
        value: '+856'
    },
    {
        text: 'Latvia (+371)',
        value: '+371'
    },
    {
        text: 'Lebanon (+961)',
        value: '+961'
    },
    {
        text: 'Lesotho (+266)',
        value: '+266'
    },
    {
        text: 'Liberia (+231)',
        value: '+231'
    },
    {
        text: 'Libya (+218)',
        value: '+218'
    },
    {
        text: 'Liechtenstein (+423)',
        value: '+423'
    },
    {
        text: 'Lithuania (+370)',
        value: '+370'
    },
    {
        text: 'Luxembourg (+352)',
        value: '+352'
    },
    {
        text: 'Macau (+853)',
        value: '+853'
    },
    {
        text: 'Macedonia (+389)',
        value: '+389'
    },
    {
        text: 'Madagascar (+261)',
        value: '+261'
    },
    {
        text: 'Malawi (+265)',
        value: '+265'
    },
    {
        text: 'Malaysia (+60)',
        value: '+60'
    },
    {
        text: 'Maldives (+960)',
        value: '+960'
    },
    {
        text: 'Mali (+223)',
        value: '+223'
    },
    {
        text: 'Malta (+356)',
        value: '+356'
    },
    {
        text: 'Marshall Islands (+692)',
        value: '+692'
    },
    {
        text: 'Mauritania (+222)',
        value: '+222'
    },
    {
        text: 'Mauritius (+230)',
        value: '+230'
    },
    {
        text: 'Mayotte (+262)',
        value: '+262'
    },
    {
        text: 'Mexico (+52)',
        value: '+52'
    },
    {
        text: 'Micronesia (+691)',
        value: '+691'
    },
    {
        text: 'Moldova (+373)',
        value: '+373'
    },
    {
        text: 'Monaco (+377)',
        value: '+377'
    },
    {
        text: 'Mongolia (+976)',
        value: '+976'
    },
    {
        text: 'Montenegro (+382)',
        value: '+382'
    },
    {
        text: 'Montserrat (+1-664)',
        value: '+1-664'
    },
    {
        text: 'Morocco (+212)',
        value: '+212'
    },
    {
        text: 'Mozambique (+258)',
        value: '+258'
    },
    {
        text: 'Myanmar (+95)',
        value: '+95'
    },
    {
        text: 'Namibia (+264)',
        value: '+264'
    },
    {
        text: 'Nauru (+674)',
        value: '+674'
    },
    {
        text: 'Nepal (+977)',
        value: '+977'
    },
    {
        text: 'Netherlands (+31)',
        value: '+31'
    },
    {
        text: 'Netherlands Antilles (+599)',
        value: '+599'
    },
    {
        text: 'New Caledonia (+687)',
        value: '+687'
    },
    {
        text: 'New Zealand (+64)',
        value: '+64'
    },
    {
        text: 'Nicaragua (+505)',
        value: '+505'
    },
    {
        text: 'Niger (+227)',
        value: '+227'
    },
    {
        text: 'Nigeria (+234)',
        value: '+234'
    },
    {
        text: 'Niue (+683)',
        value: '+683'
    },
    {
        text: 'North Korea (+850)',
        value: '+850'
    },
    {
        text: 'Northern Mariana Islands (+1-670)',
        value: '+1-670'
    },
    {
        text: 'Norway (+47)',
        value: '+47'
    },
    {
        text: 'Oman (+968)',
        value: '+968'
    },
    {
        text: 'Pakistan (+92)',
        value: '+92'
    },
    {
        text: 'Palau (+680)',
        value: '+680'
    },
    {
        text: 'Palestine (+970)',
        value: '+970'
    },
    {
        text: 'Panama (+507)',
        value: '+507'
    },
    {
        text: 'Papua New Guinea (+675)',
        value: '+675'
    },
    {
        text: 'Paraguay (+595)',
        value: '+595'
    },
    {
        text: 'Peru (+51)',
        value: '+51'
    },
    {
        text: 'Philippines (+63)',
        value: '+63'
    },
    {
        text: 'Pitcairn Island (+64)',
        value: '+64'
    },
    {
        text: 'Poland (+48)',
        value: '+48'
    },
    {
        text: 'Portugal (+351)',
        value: '+351'
    },
    {
        text: 'Puerto Rico (+1-787)', //1-787, 1-939
        value: '+1-787'
    },
    {
        text: 'Qatar (+974)',
        value: '+974'
    },
    {
        text: 'Republic of the Congo (+242)',
        value: '+242'
    },
    {
        text: 'Reunion (+262)',
        value: '+262'
    },
    {
        text: 'Romania (+40)',
        value: '+40'
    },
    {
        text: 'Russia (+7)',
        value: '+7'
    },
    {
        text: 'Rwanda (+250)',
        value: '+250'
    },
    {
        text: 'Saint Barthelemy (+590)',
        value: '+590'
    },
    {
        text: 'Saint Helena (+290)',
        value: '+290'
    },
    {
        text: 'Saint Kitts and Nevis (+1-869)',
        value: '+1-869'
    },
    {
        text: 'Saint Lucia (+1-758)',
        value: '+1-758'
    },
    {
        text: 'Saint Martin (+590)',
        value: '+590'
    },
    {
        text: 'Saint Pierre and Miquelon (+508)',
        value: '+508'
    },
    {
        text: 'Saint Vincent and the Grenadines (+1-784)',
        value: '+1-784'
    },
    {
        text: 'Samoa (+685)',
        value: '+685'
    },
    {
        text: 'San Marino (+378)',
        value: '+378'
    },
    {
        text: 'Sao Tome and Principe (+239)',
        value: '+239'
    },
    {
        text: 'Saudi Arabia (+966)',
        value: '+966'
    },
    {
        text: 'Senegal (+221)',
        value: '+221'
    },
    {
        text: 'Serbia (+381)',
        value: '+381'
    },
    {
        text: 'Seychelles (+248)',
        value: '+248'
    },
    {
        text: 'Sierra Leone (+232)',
        value: '+232'
    },
    {
        text: 'Singapore (+65)',
        value: '+65'
    },
    {
        text: 'Sint Maarten (+1-721)',
        value: '+1-721'
    },
    {
        text: 'Slovakia (+421)',
        value: '+421'
    },
    {
        text: 'Slovenia (+386)',
        value: '+386'
    },
    {
        text: 'Solomon Islands (+677)',
        value: '+677'
    },
    {
        text: 'Somalia (+252)',
        value: '+252'
    },
    {
        text: 'South Africa (+27)',
        value: '+27'
    },
    {
        text: 'South Korea (+82)',
        value: '+82'
    },
    {
        text: 'South Sudan (+211)',
        value: '+211'
    },
    {
        text: 'Spain (+34)',
        value: '+34'
    },
    {
        text: 'Sri Lanka (+94)',
        value: '+94'
    },
    {
        text: 'Sudan (+249)',
        value: '+249'
    },
    {
        text: 'Suriname (+597)',
        value: '+597'
    },
    {
        text: 'Svalbard and Jan Mayen (+47)',
        value: '+47'
    },
    {
        text: 'Swaziland (+268)',
        value: '+268'
    },
    {
        text: 'Sweden (+46)',
        value: '+46'
    },
    {
        text: 'Switzerland (+41)',
        value: '+41'
    },
    {
        text: 'Syria (+963)',
        value: '+963'
    },
    {
        text: 'Taiwan (+886)',
        value: '+886'
    },
    {
        text: 'Tajikistan (+992)',
        value: '+992'
    },
    {
        text: 'Tanzania (+255)',
        value: '+255'
    },
    {
        text: 'Thailand (+66)',
        value: '+66'
    },
    {
        text: 'Togo (+228)',
        value: '+228'
    },
    {
        text: 'Tokelau (+690)',
        value: '+690'
    },
    {
        text: 'Tonga (+676)',
        value: '+676'
    },
    {
        text: 'Trinidad and Tobago (+1-868)',
        value: '+1-868'
    },
    {
        text: 'Tunisia (+216)',
        value: '+216'
    },
    {
        text: 'Turkey (+90)',
        value: '+90'
    },
    {
        text: 'Turkmenistan (+993)',
        value: '+993'
    },
    {
        text: 'Turks and Caicos Islands (+1-649)',
        value: '+1-649'
    },
    {
        text: 'Tuvalu (+688)',
        value: '+688'
    },
    {
        text: 'U.S. Virgin Islands (+1-340)',
        value: '+1-340'
    },
    {
        text: 'Uganda (+256)',
        value: '+256'
    },
    {
        text: 'Ukraine (+380)',
        value: '+380'
    },
    {
        text: 'United Arab Emirates (+971)',
        value: '+971'
    },
    {
        text: 'United Kingdom (+44)',
        value: '+44'
    },
    {
        text: 'United States (+1)',
        value: '+1'
    },
    {
        text: 'Uruguay (+598)',
        value: '+598'
    },
    {
        text: 'Uzbekistan (+998)',
        value: '+998'
    },
    {
        text: 'Vanuatu (+678)',
        value: '+678'
    },
    {
        text: 'Vatican (+379)',
        value: '+379'
    },
    {
        text: 'Venezuela (+58)',
        value: '+58'
    },
    {
        text: 'Vietnam (+84)',
        value: '+84'
    },
    {
        text: 'Wallis and Futuna (+681)',
        value: '+681'
    },
    {
        text: 'Western Sahara (+212)',
        value: '+212'
    },
    {
        text: 'Yemen (+967)',
        value: '+967'
    },
    {
        text: 'Zambia (+260)',
        value: '+260'
    },
    {
        text: 'Zimbabwe (+263)',
        value: '+263'
    }
]

export {
    travelTypes,
    cabinClasses,
    passengers,
    countryCodes
}
