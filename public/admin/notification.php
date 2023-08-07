<?php
if (isset($_SESSION['message_success'])) :
?>
    <?php
    echo '<div id="toast" class="w-auto rounded-[8px] h-auto z-[1010]  items-center justify-center absolute left-40 right-40 transition-all duration-300 ease-in  top-2 "> 
            <div class="bg-green-100 border-l-4 rounded-[8px] border-green-500 text-green-700 p-4" role="alert">
             <p class="font-bold">Féliciter</p>
             <p> ' . $_SESSION['message_success'] . '</p>
            </div>
        </div>'; ?>
<?php
    unset($_SESSION['message_success']);
endif;
?>

<?php
if (isset($_SESSION['message_error'])) :
?>
    <?php
    echo '<div id="toast" class="w-auto rounded-[8px] h-auto z-[1010]  items-center justify-center absolute left-40 right-40 transition-all duration-300 ease-in  top-2 "> 
            <div class="bg-red-100 border-l-4 rounded-[8px] border-red-500 text-red-700 p-4" role="alert">
             <p class="font-bold">Être averti</p>
             <p> ' . $_SESSION['message_error'] . '</p>
            </div>
        </div>'; ?>
<?php
    unset($_SESSION['message_error']);
endif;
?>