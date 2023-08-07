 <div class="w-full h-[62px] bg-[#7b7b8a] sticky top-0 left-0 z-[1000]">
     <div class="w-full h-full mx-auto sm:px-3 max-w-[1400px] relative flex justify-end sm:flex">
         <!-- nav search & control user account -->
         <div class="flex items-center w-1/2  transition-all ease-in duration-300  justify-end">
             <form action="search" method="get" class="relative items-center h-10 min-w-auto xs:w-[250px] sm:w-[250px] md:w-[250px] flex-1 mx-8 rounded-full bg-[#1f2937] overflow-hidden transition-all duration-300 ease-in xs:hidden sm:hidden md:flex">
                 <div class="absolute flex items-center top-0 bottom-0 left-4 cursor-pointer">
                     <svg width="16" height="16" fill="currentColor" color="#d1d5db" focusable="false">
                         <path fill-rule="evenodd" clip-rule="evenodd" d="M7 0c3.87 0 7 3.134 7 7a6.97 6.97 0 01-1.394 4.192l3.101 3.1a1 1 0 01-1.414 1.415l-3.1-3.1A6.97 6.97 0 017 14c-3.866 0-7-3.13-7-7s3.13-7 7-7zM2 7c0 2.76 2.24 5 5 5s5-2.24 5-5-2.24-5-5-5-5 2.24-5 5z"></path>
                     </svg>
                 </div>
                 <input name="query" aria-label="search" id="searchForm" spellcheck="false" autocomplete="off" size="1" placeholder="Rechercher" tabindex="0" type="text" class="h-full w-full appearance-none box-border flex-1 outline-none border-none bg-transparent text-white text-[14px] py-1 pr-8 pl-10 focus:bg-[#374151]" />
             </form>
             <div class="flex items-center h-full">
                 <!-- no signin -->
                 <?php
                    if (isset($_SESSION['admin_id']) == "") {
                        echo '<div class="relative items-center justify-between pl-2 lg:flex sm:hidden xs:hidden">
                            <a href="admin-register.php" id="navSignup" class="whitespace-nowrap no-underline visited:text-white mx-4 my-0 font-normal text-[14px] transition-all ease-linear duration-100 hover:text-[#3b82f6]">S`inscrire
                            </a>
                            <div class="sc-djTcra gBCgCr"></div>
                            <a href="admin-login.php" id="navSignin" class="whitespace-nowrap no-underline visited:text-white mx-4 my-0 font-normal text-[14px] transition-all ease-linear duration-100 hover:text-[#3b82f6]">Connexion</a>
                        </div>';
                    };
                    ?>
                 <!--  signin -->
                 <?php
                    if (isset($_SESSION['admin_id']) != "") {
                        if (isset($_SESSION['admin_role']) == 'admin') {
                            $admin_id = $_SESSION['admin_id'];
                            $selectAdmin = mysqli_query($conn, "SELECT * FROM `users` WHERE id = '$admin_id'") or die('query failed');
                            if (mysqli_num_rows($selectAdmin) > 0) {
                                $fetch = mysqli_fetch_assoc($selectAdmin);
                            };
                            if ($admin_id) {
                                echo '
                           <div class="user-account flex items-center justify-center relative cursor-pointer text-[#9CA3AF] hover:text-white py-[6px] px-1 my-0">   
                           <img class="user-picture w-[50px]  h-[50px] rounded-full" src="/Sallahly/public/uploads/' . $fetch['image'] . '" alt="userPic">
                            <div class="gap-3 w-auto h-auto min-h-[250px] min-w-[250px] bg-[#1f2937] user-menu absolute right-0 top-full px-4 py-0 border-l-[1px] border-r-[1px] border-b-[1px] shadow-sm rounded-br-[8px] rounded-bl-[8px] z-[100]">
                                <h1 class="font-thint text-center text-white px-2 py-1 text-[18px]">
                                    Bienvenue chez Sallahly Adminstrateur
                                </h1>
                                <div class=" items-center flex gap-1 py-2 border-b-[1px]">
                                    <img class="user-picture hover:scale-150 w-[50px] p-[4px] h-[50px] rounded-full" src="/Sallahly/public/uploads/' . $fetch['image'] . '" alt="userPic">
                                    
                                    <div class="flex items-center gap-1 px-2 py-1">
                                        <h5 class=" leading-5 font-semibold whitespace-nowrap no-underline text-white my-0  text-[14px] transition-all ease-linear duration-100 ">' . $fetch['firstname'] . '</h5>
                                        <h5 class=" leading-5 font-semibold whitespace-nowrap no-underline text-white my-0  text-[14px] transition-all ease-linear duration-100 ">' . $fetch['lastname'] . '</h5>
                                    </div>
                                </div>
                                <div class="my-3 text-md w-full"> <a href="edit-admin-profile.php" class="w-full whitespace-nowrap px-2 py-2 cursor-pointer no-underline h-auto text-white my-0  text-[14px] font-bold text-left transition-all ease-linear duration-100 hover:text-[#3b82f6]">Modifier profile</a></div>
                                <div class="my-3 text-md w-full"> <a href="messageries.php" class="w-full whitespace-nowrap px-2 py-2 cursor-pointer no-underline h-auto text-white my-0  text-[14px] font-bold text-left transition-all ease-linear duration-100 hover:text-[#3b82f6]">Messageries</a></div>
                                <div class="my-3 text-md w-full"> <a href="admin-logout.php" class="w-full min-w-[100%] text-center whitespace-nowrap px-2 py-2 cursor-pointer no-underline h-auto text-white my-0  text-[14px] font-bold  transition-all ease-linear duration-100 hover:text-[#3b82f6]">Déconnecter</a></div>
                            </div>
                        </div>
                        ';
                            }
                        }
                    }
                    ?>
             </div>
         </div>
     </div>
 </div>