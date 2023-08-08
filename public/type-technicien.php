<!DOCTYPE html>
<html lang="fr">

<head>
    <meta name="description" content="Sallahly is a platform for the most skilled people in the field of repairing electronic things ." />
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="./assets/sallahly.png" />
    <link rel="stylesheet" href="../src/css/styles.css" />
    <link rel="stylesheet" href="../dist/output.css" />
    <link href="https://fonts.googleapis.com/css2?family=Reem+Kufi+Fun:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <title>Sallahly | Créer un compte technicien</title>
</head>

<body>

    <div class="flex items-center justify-center w-full h-full min-h-screen relative bg-cover bg-no-repeat" style="background-image: url(./assets/ott2.jpg);">
        <!-- Logo -->
        <div class="absolute top-[20px] left-[40px] w-[140px] ">
            <div class="relative w-full-h-full">
                <a href="home.php" class="font-bold text-white text-[45px] logo">صلحلي</a>
                <span class="text-[12px] font-semibold text-white absolute bottom-0 right-0  ">Réparez vos
                    affaires</span>
            </div>
        </div>
        <div class="flex p-6 bg-black w-[600px] max-w-[100%] h-auto max-h-[650px] shadow-md overflow-y-auto overflow-x-hidden rounded-[8px] text-left outline-0 relative px-[100px] hide-scrollbar">
            <a href="register-technicien.php?type=graduated" class="text-[#3b82f6] cursor-pointer flex relative flex-col justify-between min-w-[222px] p-[24px] transition-all nav-link rounded-b-md">
                <div>
                    <p class="text-white text-center m-0 text-[16px] font-bold">
                        Diplomé&nbsp;!
                    </p>
                    <div class="divider h-1 my-4 bg-[#4B5563] transition-all ease-in duration-300"></div>
                    <img src="./assets/degree.svg" alt="college degree icon" />
                    <p class="text-[#9CA3AF] text-center m-0 text-[14px] font-[400] leading-[1.4] mt-8">
                        Vous avez un diplome ? Rejoignez nous maintenant
                    </p>
                </div>
                <svg width="24" height="24" fill="currentColor" focusable="false" class="m-[0px auto] text-white opacity-0 absolute left-[calc(50%-12px)] bottom-0 transition-all duration-300 ease-in">
                    <path d="M13.293 7.707a1 1 0 111.414-1.414l5 5a.998.998 0 010 1.414l-5 5a1 1 0 01-1.414-1.414L16.586 13H5a1 1 0 110-2h11.586l-3.293-3.293z"></path>
                </svg>
            </a>
            <a href="register-technicien.php?type=non-graduated" class="text-[#3b82f6] cursor-pointer flex relative flex-col justify-between min-w-[222px] p-[24px] transition-all nav-link rounded-b-md">
                <div>
                    <p class="text-white text-center m-0 text-[16px] font-bold">
                        Non diplomé&nbsp;!
                    </p>
                    <div class="divider h-1 my-4 bg-[#4B5563] transition-all ease-in duration-300"></div>
                    <img src="./assets/resume.svg" alt="resume icon" height="200" width="175" />
                    <p class="text-[#9CA3AF] text-center m-0 text-[14px] font-[400] leading-[1.4]">
                        Aucun diplome ? Nous allons vous former
                    </p>
                </div>
                <svg width="24" height="24" fill="currentColor" focusable="false" class="m-[0px auto] text-white opacity-0 absolute left-[calc(50%-12px)] bottom-0 transition-all duration-300 ease-in">
                    <path d="M13.293 7.707a1 1 0 111.414-1.414l5 5a.998.998 0 010 1.414l-5 5a1 1 0 01-1.414-1.414L16.586 13H5a1 1 0 110-2h11.586l-3.293-3.293z"></path>
                </svg>
            </a>
        </div>
    </div>
    <script type="text/javascript" src='../src/js/index.js'></script>
</body>

</html>