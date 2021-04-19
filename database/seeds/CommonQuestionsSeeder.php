<?php

use App\Models\CommonQuestion;
use Illuminate\Database\Seeder;

class CommonQuestionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CommonQuestion::create([
            'question_ar'  => 'ما هو لارافيل',
            'question_en'  => 'what is laravel',
            'answer_ar'    => 'لارافل هو منصة برمجية لتطبيقات الإنترنت مفتوح المصدر أو إطار عمل لتطوير تطبيقات الويب مكتوب بلغة بي إتش بي. قام Taylor Otwell بإطلاق لارافل في شهر فبراير 2012',
            'answer_en'    => 'Laravel is a web application framework with expressive, elegant syntax. We have already laid the foundation — freeing you to create without sweating the small',
        ]);

        CommonQuestion::create([
            'question_ar'  => 'ما هو الكومبايلر',
            'question_en'  => 'what is compiler',
            'answer_ar'    => 'المحول البرمجي مترجم الأكواد للغة الآلة أو لغة الأسمبلي ‏ الجامع أو المصرف أو المترجم هو برنامج حاسوبي يقوم على تحويل الملفات المصدرية إلى أوامر مباشرة يفهمها الحاسوب وينفذها ',
            'answer_en'    => 'In computing, a compiler is a computer program that translates computer code written in one programming language (the source language) into another language (the target language). ... A language rewriter is usually a program that translates the form of expressions without a change of language.',
        ]);

        CommonQuestion::create([
            'question_ar'  => 'ما هو الاي بي اي',
            'question_en'  => 'what is api',
            'answer_ar'    => 'واجهة لبرمجة التطبيقات أو بيئة برمجة التطبيقات ‏ وصفٌ العناصر البرمجيّة حسب وظائفها، ومدخلاتها ومخرجاتها. ويتمثل الهدف الرئيسيّ منها في توفير قائمة من الوظائف المستقلّة تمامًا عن الآلية التي نفّذت بها، لتتيح للآخرين التواصل معها من خلال أيّ آلية',
            'answer_en'    => 'API is the acronym for Application Programming Interface, which is a software intermediary that allows two applications to talk to each other. Each time you use an app like Facebook, send an instant message, or check the weather on your phone, you are using an API.',
        ]);
    }
}

