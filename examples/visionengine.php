<?php

set_time_limit(610);

require_once __DIR__ . '/../vendor/autoload.php';

use Solver\Solver;
use Dotenv\Dotenv;

try {
    $dotenv = Dotenv::createImmutable(__DIR__ . '/..');
    $dotenv->load();

    $dotenv->required('APIKEY')->notEmpty();
} catch (\Exception $e) {
    echo "Error loading .env file: " . $e->getMessage() . "\n";
    exit(1);
}

$solver = new Solver([
    'apiKey' => $_ENV['APIKEY']
]);

try {
    $results = $solver->visionengine([
        'module' => 'slider_1',
        'image' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAC8AAAArCAYAAADottG6AAAP0UlEQVR4nLR5C5Ac1XX2d/sxPY/d0ax2tatZQL9UP0WIBEEpyqHkCiUTkmAn2hhcYQgJFTvEhYwDBiHLYEGs3UBIgQGJIIMFDpYTV4J3U4lAApmKFYgFEo/gyAtSDCxh0S77nvf09Pt26ty+PRotEgaq0qWeGXXfPvc7537nnO/2avjwg53mehjf37ZtGyuVSrqiKKlKpZLzPK/bdV36Nvbs2fMpAJcDyAGoANhRKBR+ODIywttt0AfZGRoaare9+PdHBidAHTt2jK1evZpNT0+Lcfl8nozxoaGhMJ4QgFYqlZLFYrHLNM3l9Xq9/8CBA88BoDMFYB+AIoBuAOsApAFcwhirxnN0dXUp5XKZLV++nM3MzIRdXV1huVzmi5z8SODZlVdeqSxfvlyrVCpaKpXSgiBQE4lEqGlaoGmaZ5qmLx1RJiYmDM/zuorFYr5Sqax88cUXn5XAJ6759s6BMORIqCoUMHhBgL//xo17AZxFDhQKhWYymdSDIEh4nqdpmqYACBKJhG8YhgvAy+fzgQzWB5xYDJ6tX79eXbFiheH7fopz3mHbdnrPnj1TAG4C8CUAK+XY5wHsvvbaa/99bm4uXy6XV7UD/4sHdw2AMTGBrijwA184ECDEzpu+0u5A1rbtTs/z0vv3718D4IsAPiPnOEJzDA4OPnQqB9giqqjz8/PJUqmUbTQay+r1+rLnn39+TAIizh74zFc3b27aFl55/OH7pTP/cPHFFx86ePDgv8XAVxf+dEBRFPAwBDmgKgo8zwNdC4IAnuvif54abjmwbt263z18+PDnAPw2gB8BmPzN6762/YVH//ZOAJcC6JdUGz8VeMHxWq1mzM/P58rlcn+5XF5Zr9fPGh0dXQ9ATZ9/oQDEGBOgQs7Fg83XXzsE4C0Aawl4xwWfGqDrNDaU4ziNDTlCEbewNa117EjsAEX4HAAjnWt/Y3scXoXRfED1Zy/RuE7G2G+1R78F/rrrrtMcx8nUarX83Nzc2ZVK5dw33njjVQD/nDr317rFSAJzCq5Zv3idHCgmzz1/gIgShmELJDkbHe3FJVoR8ex/jxKw7tSvXvDpk62G0k502L94nZL+Dxljz8fXRKmkqI+Pj6sAkrZtL2k2m72NRqNPcu8QGAZO2Aw/kDnJXznv021TnhZAjD1yiInVSJ17/kA0JnKGsQ/SQh5H5OqeBL5VrizLSlCCep6XcRyHylwPRZQpaitg4iOMnIidORFJJr/Dk1OLtbFFJDGTpiJ4CmMnnAx5FKDFTgMLAC5ov9BqUtlsljUaDRaGoTg554H0dgPTtBOROelDgj5lJQ5PONg+hrV9xRGnfyI/QoAHAjiTTuAE4Xpkz2gdVFexevXqsFarhel0OqD6ahiGlUgkTAl+nfnzVzdB10An03WwRAIsoYMZSSCVAtJpIJ2KzlQSLGmIe/F98W0YAD1Dz6samKoCamzPAGh8ks4UFMMQ15ieANN04vsmSZk9iyMv3DcMI/A8z+3o6GiYplnOZDK53t7eDXNzc48BKCCdaS07ZAkUFJAVSBiha4oSRZNHkaOIit+KpAtdkzYYXaczXsmYgvGYE2EvAPhhoVCYwCI2Iq7xpVIpXavVlpXL5RUzMzOrisVi/9jY2E5Zv63c569a1w4aKp0qEOdEzHn6LcHHDoRMacsP5cS4mFbCEUmb2CkeovKv/3RYygwhKdpLZbsw49T6e3t7TU3TKpzzUhAEmRUrVtx8/PjxKwC8W3nyRw8v+8pNX41LAlOiJCUJIMqiqoiJox4QcxkIgyCakRym+2HYVlbC1rNo1YAIeOmxnY8AuB7AqkKhUF+cVSc1qe7ubr1YLHaWSqXemZmZFdPT02cdPHhwJO6c533rr4VWoYmp8YSiaoQicZQwSjpVSoKQMfhhCI9FkiCOcBiDb+sZLKYJ58JZVSxcNG7s/rtbnXhx5GM5qvT396tTU1NGrVZbYppm38zMzJlPPvnkT2Pgv3PXfQMiigjBA47YiVBOqjEGDQy6oBQBjsD7IUdAjtAwciQMwdsqp3CWc6ghBSCimCLO6B6VzmfvvL3dgQraIi6Av/322wnGWGexWOyZn5/PP/XUU6/GwK/+mx0Dcc/kot0H4DyEpirQiO80qZQEpF14zGsZUSEpJB2i/yOSGGFU45W2SHLSPkFkn+7RHIyHeGLw1g84QLJAz+fzpGk66vV6D0nbp59+ugX86w8+MhDwUESNC/ChbI4Rb2lpeYvHUc6J6CmyslAEqdIQpRDRSlMiWz6P4t+Si4JOvFX/6TOQtZ4wPHr75pMcoMh3NJvNjpmZGQF8YWEh//LLL5MAWvqt7zw6oMRJ2SpdkTGKHBkk40orsmGLz+0JFV9niFYoAh2vZGQjkFQk53SFQVUVcc8LuJgrbtzf2br5QMQ2dgnbunVr3+zs7FLS5AsLC2ceOnRoFMBP7vru97pVWRIDSiSmiGgqsp6HLYMn2usJ1SgpIBzk8APeqttEKzqZ1D2eHwhnYiv02wl4RB3pNElqmldXFSQ1FQ/ctrkJ4Pe1ZrNJSjJXrVZ7KpXKUinGjngclzI1qhykbcg8TQSZdIpMVMFZOhWIzQbnEVBaFY9zETnX98WzZMNxXfFcSmHo0BUorosE1WxVgarp8BUFVQHeF5TTNTWSCoxFNgIhxan2r9U8z0u5rpuxbZvoQ83AorsN1xOTWp4XLVsYLSFFxJfUCHgAVVFl1QCyCR26qqJh25Im5CjgEHjPi2hCuj4IkDMS0DqT6E5qUMJAcF1TKdkDpPQAFjnhclSaTREsy3FhWhbS1OnjJsWID1FplbJQ6JnrF8oVEUU/COB4roiu5/swHQeO54tOmNR0uJ4rxtDGIaVpyGVSWKg1YNo2komEoBpFjNPOSjYrOsuMoVpLoS9jIKNwaLR5kbsuQ9eg6gkkEAr+N5oOas0mdCOJgDp6pHPuog5LO1/HMAw7kUg4y5YtWz8/Pz/1g6FvvvVH3/jLDRRhQ1IkoSowEgnYAOqmC9txkNA0UZdp6+y6DqabpsiPwHNRcxzhhMs5AiqTsiHpug5D1WA1TTTNFJZ3poTthu3AdH2kkwaWdHQIB1QtATAHSSOJvuV9+Ls7tpCy7KBNibZkCfUks2bbNlEn5XkeufZnVCqfuPfOfZddd+OGpm1L6cJgW7asLiESug6f6n7ARY1PahochGhYTlSJggCapiHwffiuH8l3pgje8jD6f2jZsGhlAl8kNtksuwHerzWh6QnklmSxNNclHH4sAn4elUpBG03TzO7ubloBnXOuh2GorFq16sp3332XBjz37KMP7fvC17ZssF1XtPaUrosy9syuh4bl8p0JoEQ9AcDez16/6e5U5xJw3xdJSBSpmk3YliXo1XRd4WhHOo3//MfHSepukHZS0s5P1vxB4UuU2H7gY7pYRHd3DS/9YFcLeLwRZw888ECqWq2mHMfJTU9P91Kdn5+f7y0Wi9mxsbFY17yx6a57Ntieh0eG7tgkxdIUgCGZIyvlm4RrANx/y7077iagVGYpwS3Xg09n4MN2XFiugx8/vH0rgM0ASLXulm8nyIlt8m3BI2d87vLtKlNw/Jl/+QBwEfnDhw+7tBkxDAP5fB6qqjJ5hmvXrv3CkSNHxApsv+NWMnBATnjgiiuu2GWaZme5XP5ssVhcWqlUpkul0tcB3Ne7pFNICKo8RKuaHSU1FQBqRpHmF3buuvrqqw83Go1z6vW62De7rvvT0dHR/0f339+/Z5N89SGADw4OzixWlWx4eFgxTVMvl8vpUqnURZGvVCq99Xo9yzkP9+/f/4JcgU7aim3atOmbzWZTr9frnQsLC32ywS2rVqskMWiy1x56/PubQykrTMeLumgYwnY93HPLjfcDuHDLli1XBUGg12q1rGVZyyzL6nMcJ6soCt+7d+96AFcCmJPAp44dOxaMjIwE7Xo+LBQKfHh42APQjLV9R0eHS7KB/nPDDTcs3blzJ63AzVu2bLmdMcZzuZyWTqc9xphOfcI0zaxpmmkAPwdwTtn2oMk9bp2o4gWoWU1Yvmgy5wD4j0wmU+vo6FCz2azTbDZd13Ut3/czQRAEN99882s7duwgiuzeuHHj+/l8noCftFuONyMtB+r1OiUwd13X4ZwnESlJ65577mmm0+lb33vvPR/RvjdQFEVLJpO033VoI6PremzcqjuekABCiKmqeLuaUNKiackg5QC4r7zyCiNb/f39PoHnnJO65TTnfffd9+1sNuvK95V88WZEafstHCgWi94ZZ5zRzOVylUwms0BnT09Ptaurq0n3RkZGOOUIPWAYRki5QeWQ8oQqFYDPA3gro6swVFVUKOrEQeALJ4RqBCYBfHFoaCiUb4LdeM5sNrvQ399fzOfz9Uaj4WzcuNE/FXCc7i0x7arWrFnDjh49Ku6vWbNGOBYPoByZnJxMVKvVzomJifz4+PiKycnJFW+++WYPgMtuu//Bdb4fQNN1ITEU+ZqEBIMbBHBdD7u23fYWgGcYY7e0241/Hz16NDzd2+HFtGk/4ocWOxa/k1dmZmY0x3GSMtFylGQS+JepVDYsZx1RhjQRrYrv+3D9ALbnw/U8IbaoFFJFCcOwwhgTf1UoFApBu5I+Hej4UD7kXrjohDSsZDIZseuyLGtpo9HoeeGFF86Ogf/en1+/fWZ6CnajgeJCEbNz82g0THDPgxr4MGhT7vvYeMdfbafx9FwYhttOMe8vPU73l5FTHhT1iy66SJ+YmOicnJzsO378+Fm7d+9+CcB/AXhnw5evv9S0neidvK6jaVlC5qZTSWSSyUgqcI6kYcCXavWJHffGDejX2/enH+X4sMif8pidnWW+7xPdEkEQJNevX/8nUmv8/33fe2QfKclkQkcmoaO/eynO6FmKTiMBJeRwbAuNRgPzxSJKlUo78Es+LvBPBL6vry9MpVJUJj1ZIp3Vq1cXpAPn7X/8u/umZ+fw7uQkxqemMDU7h4ZloVipolytwnNsBJ6DH3//JK3y3sfFgY9Lm/jNWnd3d7pWq3VNT08vn5yc7J+enu5bWFjIvfPOO0/EWui8yzZscD1faHTSOI5ti3JJuv/4i8+1gBcKhYlf9oez0x0fN/JiMwTAUVW11tnZOd/d3T3T09Mz19XVVV25cuUfxyvwxrP79nVks0im0tA1HQkjKfjfDnxwcHDykwLHaUrlhx5URoeHh33TNC3DMFgQBOKVuFDqisLOPvvsa8bGxoSY+9meYdpr7r3w8qvuPrp/z9Z2kSVb/icGjk9Am9ZzsZgbHx9PO46zdHZ2tnd2djZfKpWWmaa5ZHR0dBeAHQDWS8lMCfkgXRscHCR5cNrO+X8NvuUAdVrOeWZ2drarVCr1lkqlnnq9vsR1XV3TNDedTlPLn+3s7JzL5XJl0kIS+Eeu56c7/jcAAP//BXEPD6TebYoAAAAASUVORK5CYII=',
        'imageBackground' => 'data:image/jpeg;base64,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'
    ]);

    echo json_encode($results, JSON_PRETTY_PRINT) . "\n";
} catch (\Exception $e) {
    if ($e instanceof \Solver\Exceptions\SolverException) {
        echo "\033[31m" . $e->getTaskId() . " - " . $e->getErrorCode() . " - " . $e->getErrorDescription() . "\033[0m";
    } else {
        echo "Error: " . $e->getMessage() . "\n";
    }
    exit(1);
}

exit(0);
