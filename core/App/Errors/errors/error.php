<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Error Occurred</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="py-10 bg-gray-950">

        <div class="mx-auto px-6 lg:max-w-screen lg:px-8">
            <div class="grid gap-4 grid-cols-1">
                <div class="relative col-span-2">
                    <div class="w-full py-10 px-8 flex items-center">
                        <div class="w-32 flex items-center justify-end">
                            <svg class="w-32 h-32" viewBox="0 0 1062 1062" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g filter="url(#filter0_f_1635_1383)">
                                    <circle cx="531" cy="531" r="337" fill="#FF2121"/>
                                </g>
                                <g filter="url(#filter1_f_1635_1383)">
                                    <circle cx="531" cy="531" r="267" fill="#FF3E3E"/>
                                </g>
                                <g filter="url(#filter2_f_1635_1383)">
                                    <circle cx="531" cy="531" r="191" fill="#FF5F5F"/>
                                </g>
                                <path d="M550 392.727L547.273 593.455H515.636L512.909 392.727H550ZM531.455 674.182C524.727 674.182 518.955 671.773 514.136 666.955C509.318 662.136 506.909 656.364 506.909 649.636C506.909 642.909 509.318 637.136 514.136 632.318C518.955 627.5 524.727 625.091 531.455 625.091C538.182 625.091 543.955 627.5 548.773 632.318C553.591 637.136 556 642.909 556 649.636C556 654.091 554.864 658.182 552.591 661.909C550.409 665.636 547.455 668.636 543.727 670.909C540.091 673.091 536 674.182 531.455 674.182Z" fill="white"/>
                                <defs>
                                    <filter id="filter0_f_1635_1383" x="0" y="0" width="1062" height="1062" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                        <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                        <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix" result="shape"/>
                                        <feGaussianBlur stdDeviation="97" result="effect1_foregroundBlur_1635_1383"/>
                                    </filter>
                                    <filter id="filter1_f_1635_1383" x="214" y="214" width="634" height="634" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                        <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                        <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix" result="shape"/>
                                        <feGaussianBlur stdDeviation="25" result="effect1_foregroundBlur_1635_1383"/>
                                    </filter>
                                    <filter id="filter2_f_1635_1383" x="300" y="300" width="462" height="462" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                        <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                        <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix" result="shape"/>
                                        <feGaussianBlur stdDeviation="20" result="effect1_foregroundBlur_1635_1383"/>
                                    </filter>
                                </defs>
                            </svg>
                        </div>
                        <div class="w-full ml-10">
                            <p class="text-4xl font-bold text-white max-lg:text-center">
                                Unexpected Error
                            </p>
                        </div>
                    </div>
                </div>
                <div class="relative col-span-2">
                    <div class="relative bg-gray-900 flex h-full flex-col overflow-hidden rounded-[calc(theme(borderRadius.lg)+1px)] max-lg:rounded-[calc(2rem+1px)] lg:rounded-[calc(2rem+1px)]">
                        <div class="px-8 pb-3 pt-8 sm:px-10 sm:pb-0 sm:pt-10">
                            <p class="mt-2 text-2xl text-white max-lg:text-center">
                                <?= $errorMessage ?>
                            </p>
                            <p class="mt-2 max-w-lg text-xl text-zinc-400 max-lg:text-center">
                                <?= $errorFile ?> (Line <?= $errorLine ?>)
                            </p>
                        </div>
                        <div class="relative min-h-[50rem] w-full grow">
                            <div class="absolute bottom-0 left-10 right-0 top-10 overflow-y-scroll overflow-hidden rounded-tl-xl bg-gray-800 shadow-2xl">
                                <div class="flex ring-1 ring-white/5">
                                    <div class="border-b border-r border-b-white/20 border-r-white/10 bg-white/5 px-4 py-2 text-white">
                                        <?= basename($errorFile) ?>
                                    </div>
                                </div>
                                <div class="mx-6 text-white text-md">
                                    <pre class="whitespace-pre-wrap"><?php
                                        function displayCodeContext(string $errorFile, int $errorLine): void
                                        {
                                            if (!file_exists($errorFile)) {
                                                echo "<span class='text-red-500'>File not found: " . htmlspecialchars($errorFile, ENT_QUOTES, 'UTF-8') . "</span>";
                                                return;
                                            }

                                            $fileContents = file($errorFile);
                                            $lineCount = count($fileContents);
                                            $startLine = max(0, $errorLine - 15);
                                            $endLine = min($lineCount - 1, $errorLine + 14);

                                            echo "<div class='overflow-x-auto'><table class='table-auto border-collapse w-full'>";

                                            foreach (range($startLine, $endLine) as $currentLine) {
                                                $lineContent = htmlspecialchars($fileContents[$currentLine], ENT_QUOTES, 'UTF-8');
                                                $lineNumber = str_pad($currentLine + 1, 3, '0', STR_PAD_LEFT);

                                                $rowClass = ($currentLine + 1 == $errorLine) ? 'bg-red-400 text-red-600 font-bold' : 'text-gray-500';
                                                $cellClass = ($currentLine + 1 == $errorLine) ? 'bg-red-300 text-rose-800' : '';

                                                echo sprintf("<tr><td class='%s'>%s</td><td class='%s'>%s</td></tr>",
                                                    $rowClass, $lineNumber, $cellClass, $lineContent);
                                            }

                                            echo '</table></div>';
                                        }

                                        if (isset($errorFile, $errorLine)) {
                                            displayCodeContext($errorFile, $errorLine);
                                        } else {
                                            echo "<span class='text-red-500'>Ошибка: отсутствуют входные параметры.</span>";
                                        }
                                        ?></pre>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="bg-gray-900 p-6 mt-6 rounded-lg text-white">
                    <h2 class="text-xl font-bold mb-4">Request Data</h2>
                    <pre class="bg-gray-800 p-4 rounded-lg text-sm overflow-x-auto">
                        <?php print_r(request()); ?>
                    </pre>
                    <h2 class="text-xl font-bold mt-6 mb-4">Server Data</h2>
                    <pre class="bg-gray-800 p-4 rounded-lg text-sm overflow-x-auto">
                        <?php print_r($_SERVER); ?>
                    </pre>
                    <h2 class="text-xl font-bold mt-6 mb-4">Headers</h2>
                    <pre class="bg-gray-800 p-4 rounded-lg text-sm overflow-x-auto">
                        <?php print_r(getallheaders()); ?>
                    </pre>
                </div>
            </div>
        </div>
    </body>
</html>
