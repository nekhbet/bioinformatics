<?php
require(__DIR__.'/../../_common.php');

//die(1/(pow(4, 9)) * 1/(pow(4, 9)).'--');

echo implode(' ', ClumpFindingOptimized(
	//file_get_contents(__DIR__.'/../../E-coli.txt'),
	'GTGACTCATGTTCTCAAGCTAAGCTGTATTCTCCTGGAATCATGTTGAGACCGGCCGTCCTGTCGAGCTGACTGTACAACAGATATCCACCTGCCTACGCAAGTTTTGCCTTTAACACTAGCTTTGAAACACTTATCCGAGCTATCGGTCGTGCTCACCTGTTTCTCGCAACCTAGGGCTCTGGTAATTAGTCTGAAGAAATGCAGAATAGCAAAGCTTACAAGTCTAGTTGACGCATATCTGCATATATAGCGAGCATGCGCCATGGAGCCTGCTGACGTTTTTATAATTTTGTCCTTCCCAGGAAACCTGAGGAGAGGCACTTTTGAGTTACCAGCGCGGGTTTTGAGTTACCGATGAGCGCGTTCTGGCCGCTCAAGTTCCGAGCCATTGGAGTGAAGAATCGATAGCGCCGCGCGAAAATAGTGATACTTCAATCGTGGAGCTGATGATACTTCAATTGATACTTCAATGAGGTGATACTTCAATGGCCACTGATACTTCAATGTTCGCAGTTCGCGGCATGATACTTCAATTTCAATAATATGTCGCTTGATACTTCATGATACTTCAATTGGCTGGGACTGATACTTCTGATACTTCAATATCACGGGTGAACAGCTTGATACTTCAATGATACTTCAATCGCCATCGTAACCTTGATACTTCAATTAGCCGTTGCGGTGCTGCTTAGTTAGTGATACTTCAATCAGGACTTCGCTACCAGTGCCGATGATACTTCAATACCTGGTCAGTAGGTGATACTTCAATCTTCAATTAGGAAGTGCGACACGTTGATATGATACTTCAATAATGAATTGAATGATGATACTGATACTTCAATTCTGATACTTCTGATACTTCAATGAGTGGTAGTCCCAATTTACTGGCCATAGCTTGCGACGCTACAGTTGTGTAGCATGTTCGGCTTCACCGGCCATGTCACCCGCAACACGTCCAGCACCGTGATACTTCAATGCCCATTTAGAGTCCATCTGATACTTCAATGATACTTCAATACTCAAGCAGGGCAGGGGCACTTCAGGGGCACTTCTTGGGACTGCGCGCCTTACATCGGACGAGTTAGAAGATGCGCAAATCAGTAAGCCTTACATCGGATCGCCTTACATCGGATGCCTTACATCGGGCCGCCTTACATCGGGATCAATCAGTAATAGGCCTTACATCGCCTTACATCGGTTGCCTTACATCGGTCCTGCCTTACATCGGGCGCAGATCAGTATCAGTAATAGCCAGGCCTTACATCGGTTACGCCTTACATCGGGCCTTACAGCCTTACATCGGTCAGTAATAGCTAATAGCACTAAACTTTATCAGTAATAGCGCACTTTGCCTTACATCGGCCGGTAACCCACAATAGGCAGGGGCAGCAGGGGCACTTCCGGTGCAGGGGCACTTAGGGAGCCTTACAGCCTTACATCGGCCTTACATCGGGCCAGTAATAGCGGGCCTTACATCGGAGGCCTTACGCCTTACATCGGGTGCCTTACATCGGCTTGGGCCTTACGCCTTACATGCCTTACATCGGGCCTTACATCGGGCAGTAATAGCTGTTGTGGGCAGGGGATCAGTAAATCAGTAATAGCCTTACATCGGATCATATCAGTAATAGGCCTTACATCGGGTAGCATAATAACTGGATCAGTAATAGCCGCCTACGAGACCTCCTGGTGCCAGTACGAATGGTATACCAGTGCACACAGTCATTCAGCTAATCTGCTAAAGTGCACGGTCAAGACATCAAACGCATCTATTTGGGGCAAGCCACATCACTTCAGGCACGGATTGGAGGCTACATATCACTAACGGGAGCGGCCATCTAAGTTTGACAGTTTGCCCCGGTTACAATTTTTTGAAGCCACGGAGTCCCGCGACCAGGGGACGCTCGGTAAATTCAGCAGATTTGGCCGCATTCGACCTTACATGATCTGTTGGGTCATCGTACATAGTCAATGTATGTGTTCTCCTGGGTCCTGTGCTGACCAAAAAACCCCTGGCATTTCAAACCCACCTTAAAGTACATATGACTGTCTACAAGCGTGCGAAGGATAACATGACACGCGGCCGTGTGGAGCGACTAGCATAGGTCTCAGGGGTCCGTCGTGTTGCAATAACGAGCATGAGATCAGTATCGCATAGCCAGTTCTGTCGCGGCCCTTACGTACATTCATTCCTAGGTAAAGTGTGGCGGCCATGAGGCAGGAACTATCGGGACAGCGCGGCCGGCGTACATCGACCGGCGTACATCGCGTACATCGACACTCGCGGTGCACTCCAGCATCACTGGCGGCGTACATCGTCACGGCGTACATCGGGCGGCGTACATCGCGGCAACGGCGTACATCGAAGCGGCGTACATCGGAATCTCGGCGTACATCGTACATCGAGGGGCGGCGTACACGGCGTACATCGGCATCTAGTCGCGTTGGACTGTCTTTCGCTTCGGCGTACCGGCGTACATCGCGGCGTACATCGGATACGGCGTACGGCGTACATCGTCCACCTGACGTGAACATAAGCCTCTTGAGAATAGCTACAACTTGTATTTGCGATCCGGTAGGGCATTGCATCGGCGTTACCCTGTAGGAGGTACCCTGTAGGACTACTACCCTGTAGGACGTACATCGTTCCAGCGCGACAACGGCGTATACCCTGTAGGATTACCCTGTAGGACGGCGTACATCGGAAGCAGTTATACCCTGTAGGAACATCGGACTTATCTCTAAGCGGCGTATACCCTGTAGGACGTTACCCTGTAGGAGCGTACATCGTCCCGATGGGCGCACCATTCGGCGTACATCGGGAGGTTTTTACCTACCCTGTAGGAACCCTGTAGGAGGACGACGTACTTACCCTGTAGGAAACTCACGTGACATCCCTCAATACCTACCCTGTAGGATTCCTACCCTGTAGGACCCTGTAGGACAGGCCACGCCGAGAAAGACTAGAGTTAGTCCCTACCCTGTAGGAGGACACTTTGCTGTTACCCTTACCCTGTAGGATTATCGAGAGATCATAGGTACCCTGTAGGAGGAATACCCTGTAGGACCTGTAGGAGGGTACCCTGTAGGACTGTAGGATACCCTGTTACCCTGTAGGATATGCACGTTACCCTGTAGGAGATAGGAATTGTCCTTACCCTGTAGGAAGGAGATTATAGTGGGCGTTAGTACTAGGGCACGGACCGAGTAAAATCTGCTACCACTTGTGTTGCTTCGGATGGGCAGAGGGCAAGAAGGACACCGGCTTATCAGCGGGGGGCGGATGTGGCACTGCTGGTCGTCGGGCGTGTCGTGCATACTTAGTTTCTAGGCTAAGCGTTCACTCGTCCGGGACTCTTTCTCCTGTTTAAATCCTTACTCTAACACTTCCAGTAAGCACTATCTATATGCAGTAATCAACGCGGCCGGACGATTATATTCGCTATTTGTCAATGAAGAGATGTGTGCGCTCCCCGAAGGGGTACAGGTGCCGAACGGTGGTCTTTCCATTCGCAGAACCCAGCTTCGACAGATCAGTACGCTAAATGGCGCGGCGTACATTTTCATGTATGTATAGAGCTCATTATGGGTGTATTTGACCCACTTCAATTGGAAATCATGCGCATACCAATGGCACGTAGATTTTATCGATAGATTTTATCGATTATCGATATCGATGATTTTATCGAGATTTTATCGATTGGTCGCCTGCTGGATTTTATCGATTTTTATCGATGTTCCAACCGCTTGCCAGTACCGATTTTATCGATTCCAGATTTTATGATTTTATCGATGATTTTATCGAGATTTTATCGATATCGAGATTTTATCGATGATTTTATCGATATCGATTTCGTTGGACCGAAAAACGGTTAAGGCTGCAAAACGAAAACGGTTAAGTTAAGATGCAAAACGGTTAAGATTCACAGAGCACAGAGCTAAAACGGTTAAGTAAGAAAAACGGTTAAGATAAAACGGTTAAGGGGAAAAACGGTTAAGATACCGTCACAGCCTGAGATTTTATCGATGGAGCCAAGAAAAACGGTTAAGTTCTAGATTTTATCGATTCGATCGAAGGAAAAACGGTTAAGATTTTATCGAAAAACGGTTAAGTGAAAACGGTTAAGAACAAAACGGTTAAGAAAACGGTTAAGCACAAAACGGTTAAGACGATTTTATCGATATTCTCTATACGGTAAGCGAAAAACGGTAAAACGGTTAAGTGGACCAAAACGGTTAAGGTTGTAAAATTTGTTGGCGTGCACCTAAAAACGGTTAAGCGAGTATGGCCTGCGAAGAAAACGGAAAACGGTTAAGTTGGATTTTTAAAACGGTTAAGTATCGAAAAAACGGTTAAGCGGACAAAAACGGTTAAGTAAAACGGTTAAGTGGCCTTATACCTTCCAGTTCATATTCCAAAACGGTTAAGTAAGCTCGCAAAACGGTTAAGCGGTTAAGGGCCGGTGCATTGTGTAAGGCGCAGGATAGAGATGTCTTCTTGCCGCGGAACCCTGCATGGGCGCAGTTAGGCGCAACGCTAACGAAGCCGACCATGTCTTGCCAGTAATTTCTACTTTATATGACTGGTGTTGTGTATAAGGAGATAGCCCCAACCGAATCGGCACGTTGCTCCGGTTGATTGTCTCCACCGTGAGGTCGGAGTACGGTTGAAGTAGTACGGTTGAATCTGGGTCTGTCTCGCGCCAGGTACGCGCGATTTGAGAGTAGTACGGTTGAACGCCGCGCGATTTGACGATTTGAATTTGACGACGCGCGATTTGACGCGCGCGCGATTTGAGGTCTAAGTACGGTTCGCGCGATTTGATTGATAGTCGCGCGATTTGCGCGCCGCGCGATTTGATACGGAGTACGGTTCGCGCGATTTGATCGCGCGATTTGATACTCGTAAGTACGGTTGAATGTCTCGCCGGTCTGTCTCGAGTACGGTTGAACGGTTCGCGCGATTTGATCTGTCTCGCGTCTCGCGCGATTTGATAGGTTCGCGCGCGCGCGACGCGCGATTTGAAGTTCGCGCGATTTGATTTGAAGGTCTCGCGCGATTTGACGGTTGAACTAGGTCTGTCCGCGCGATTTGAATCGCGCGATTTGAGAAATAGTAAGTACGGTTGAAGAACGGTCTAGTACGCGCGCGATTTGAATTTCCTCGCGCGATTTCGCGCCGCGCGATTTGATTGAATCGGCCGCGCGATTTGAATGTCTCCGCGCGATTTGAGTTGAACGGTCGCGCGATTTGAGATTTGACGCTAATGGTTGTCTTTCAAGTCGCGCGATTTGAAAACGCCACATGTAGTTACGTGAGCAATGCCACTCTGCCGTCATGGATTCAGGGGAATTTAGCTGCGGGGATTCCCTTGTCAGCACAGTGACGCGGGTATGAGGACCAAGCACGTCGTGGCTCTGACGTGAATTCAAAATGGCTTCAGACACTGAGCAAGTTGTATTCGGGACACACGCCCGTTATAGGGGCACACGCGCCGCGAGCCATTCGCTGCTAGCGTTTATGTCCTAACAGCGGGCTGTACCCAATGCTCATATTAGCCAGAAGGAGAAATGTTACCGACACCGCGCAACGAGGCTATACTATCAAAGAATTAAAGGGTATTTTACCGAGCGAGTGAGTAATAATGACCCAATCTAACCTTATCCTATGGCGGTCCGCTGGCGGCATTGTACGCTACAATTCGGTGCCACTAGCCTCAAAACCTCCTATATTCTGGTACATCATATAAACGTATGAGCTGAAACCTCTGACGCGACGTAAGAGGATATGTGTTCAAACATTACCGCAGTGAAGTACTGGGTGTCGGTACATTGGTACGTACGCGTCTGCGGTGGGACCGCGTTAGACGATCGGGTCAGAAAGAGTATACTTTCCAATGGCCGTGGCGGCCGTGGCTCTAGCATCGGCCGTGGCGGCCGTGGCTCTACAATACGTTCGGCCGTGGCTCTTGGGGCGTGGTTTCTTACTGATGGATCCTCTACCGCACTCCACGAACTCGCTGGCTCCAAGGAGAACTCGCTGGCCCGAACTCGCTGGCGCGACTAGGGCCGTGAACTCGCTGGCGCTCTCCCTGTGGTGAGGCCGTGGCTCGAACTCGCTGGCTATCATAAGAACGAACTCGCTGGCGCTAGAGGTTTGGGAACTCGCTGGCAACTCGCTGGCTTCTGGTAGTAGGGAACTCGCTGGCCGACTTCGAACTCGCTGGCCAGGCCGTGGGCCTGTTATCCCGCGAACTCGCTGCCTGTTATCCCCCTGTTATCCCGGCTGGCCGTGGCTCGCCTGGGCCTGTTATCCCCGTGGCTCTCTGCTCCCATGGGGAACTCGCTGAACTCGCTGGCTCTGCTCTCGCCTGTTATCCCGCCTGGCCTGTTATCCCCGCGCCTGTTATCCCGGCACTCGCTGCCTGTTATCCCTATCCCCGCTGGCGGCCTGTTATCCCTTAGCCTGTTATCCCCTGTTATGCCTGTTATCCCCTCTCGATATAGGAACTCGCTGGCCTGTTATGCCTGTTATCCCGCTGGCAACTCGCTGGCTTCTGGCTCTCGATAGCCTGTTATCCCCTGTTATCCCCTGGCCTGTTATCCCCTCTCGATAACATCCTGGCTCTCGATAATTGCCTGTTATCCCGCCTGTTATCCCTACTCGATACTTTAGTACCAACGGACTAGCGCCGCGGTTGCCTGTTATCCCTGGCTTGCCTGTTATCCCACAGCAGTAGCCATTTAGCCTGTTATCCCCTGGGGCCTGTTAGCCTGTTATCCCGACTTGCCTGTTATCCCTGTTATCCCGGCCTGTTATCCCGCAGCAGTTGCGAGGTTTTGGCTCTCGATTTGAGCAGTTGCCTCGATACCACGGCGTGGCTCTCTTCCATTGGGAGCTTTCCATTGGGAGGCGCTGTTCCATTGGGAGAGTTGCTAAGGTTGAGTTCCATTGGGAGTGAGCAGTTGCAGATTTTTTCCATTGGGATTCCATTGGGAGTTTCCATTGGGAGTTCCATTGGGAGTCCATTGGGAGATAAATTCAGTTGCCTTTCCATTTCCATTTCCATTGGGAGCTTCCATTGGGAGTCATAAATTGAGCAGTTGTTCCATTTTCCATTGGGAGTTCCGCCCTCAGGTTTGAGCATTGATGACTTGCTTTCCATTGGGAGGCTCAGTAAATTTTCCATTGGGAGCTTGCTCATGACTTCCATTGTTCCATTGGGAGGTAGCGTTCCATTGGGAGACTGTCATAAATTGACTTGCTCAGAATTCGCTGTCATAAATTTCCATTGGGAGTCAGTTCCATTGGGAGGGAGTTGCGAGCAGTTGCGGTTCCATTTCCATTGGGAGGGGAGTCTGTCATTCCATTGGGAGTCAGTCTTCCATTGGGATTCCATTGGGAGAAATTAAATTTTCCATTGGGAGATGGCACTGTCATAAATTCTTCCATTGGGAGGAGTGACTTCCATTGGGAGGTTCACACCGTGACTTGCTCAGACTTGCTCAGGCCCAGCTTGACTTGCTCAGCATATGACTTGCTCAGCTTGCTCAGGCTCAGCAATGGTCGCTTGACTTGCTCAGACTTGCTCAGCCTTATAATGGGTGGCGGTCCTCGTATTGACTTGCTCAGTCAACACTGACTTGCTCAGTTGCTCAGTGAGTTGACTTGCTCAGGTGACTTGCTCAGACTTGCTCAGTCAGGACTTGCTCAGAAACGCTTGACTTGCTCAGGACTTGCTCAGATCTTACTAATATACAACGGCGAATGACTGCAGGCTGGCATGCGCAGTCTTGTCATTACGATAGACCCGGTGAGGAGTTTGTCGGGTTCAAGTGTGACGTTGTAACCGGTGAAGTATAGAGGATCACGAGCAATAGAGACTATACTTTCCTCACCAAACATCGATCAGTCCGCCCCAGTTGTCCACCCCCCGCGGGACGGGGTTACTTGCCACGTGTCTCGAAGGTCACCCAGTATTTTGGAGGTTAGCAGGAGGCATCATGCCCCGTCACTTTTGGCGAATCGAATCAGTAGCGGTGTCTCCTTTCTGCACCGTAGGGGCAGGTCTCTACCAAAATCTTCTTCAGATGTCCGCTCGAGACCACCCACTAGAGGCTGGTCGCCGTAACTAATGGAGAGTTGTCGTTTCGTTAGGTTGAATATTGTGTCAGATAGTGTTTTGCCAAGGACTCGCCTTGGACTCGAGTGGCAGCTATCGTGCTGCGCCAGGAGAAGATAACAGGACTTCTATTGTAATGCGTAACATCTCACACGGTTGGACCCCTCTATCGCCGAGGGCTTAGACTATCGTACAAGCGCCGTGTTGCTTGCGTTCGCGCGTATGCATGACGTGCAGACCGTGTCAGTCGGTGAGTTCGCTAACCGCTTTCAGGAGGTACCCCGATAACAACCC',
	12,555,19
));