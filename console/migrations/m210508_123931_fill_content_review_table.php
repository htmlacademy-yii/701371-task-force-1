<?php

use yii\db\Migration;

/**
 * Class m210508_123931_fill_content_review_table
 */
class m210508_123931_fill_content_review_table extends Migration
{
    /**
     * @note
     * fill reviews
     */
    public function safeUp(): void
    {
        /**
         * @note
         * tasks
         * fix import data for columns from data/sql/replies.sql
         */

        $this->batchInsert(\frontend\models\Reviews::tableName(),
            ['created', 'rating', 'description', 'task_id'],
            [
                ['2019-05-09', '1', 'Curabitur gravida nisi at nibh. In hac habitasse platea dictumst. Aliquam augue quam, sollicitudin vitae, consectetuer eget, rutrum at, lorem. Integer tincidunt ante vel ipsum. Praesent blandit lacinia erat. Vestibulum sed magna at nunc commodo placerat. Praesent blandit. Nam nulla. Integer pede justo, lacinia eget, tincidunt eget, tempus vel, pede.', 1],
                ['2018-10-27', '4', 'Fusce consequat. Nulla nisl. Nunc nisl. Duis bibendum, felis sed interdum venenatis, turpis enim blandit mi, in porttitor pede justo eu massa. Donec dapibus. Duis at velit eu est congue elementum.', 2],
                ['2018-11-02', '5', 'Fusce consequat. Nulla nisl. Nunc nisl.', 3],
                ['2019-06-04', '3', 'Praesent blandit. Nam nulla. Integer pede justo, lacinia eget, tincidunt eget, tempus vel, pede.', 4],
                ['2018-10-09', '3', 'In hac habitasse platea dictumst. Morbi vestibulum, velit id pretium iaculis, diam erat fermentum justo, nec condimentum neque sapien placerat ante. Nulla justo.', 5],
                ['2019-07-16', '4', 'Nullam sit amet turpis elementum ligula vehicula consequat. Morbi a ipsum. Integer a nibh.', 6],
                ['2019-01-22', '5', 'Cras mi pede, malesuada in, imperdiet et, commodo vulputate, justo. In blandit ultrices enim. Lorem ipsum dolor sit amet, consectetuer adipiscing elit.', 7],
                ['2019-06-11', '4', 'Praesent id massa id nisl venenatis lacinia. Aenean sit amet justo. Morbi ut odio.', 8],
                ['2019-02-16', '3', 'Vestibulum quam sapien, varius ut, blandit non, interdum in, ante. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Duis faucibus accumsan odio. Curabitur convallis.', 9],
                ['2019-07-16', '5', 'Aenean lectus. Pellentesque eget nunc. Donec quis orci eget orci vehicula condimentum.', 10],
                ['2018-11-11', '4', 'In hac habitasse platea dictumst. Etiam faucibus cursus urna. Ut tellus.', 10],
                ['2018-11-01', '5', 'Duis aliquam convallis nunc. Proin at turpis a pede posuere nonummy. Integer non velit.', 9],
                ['2018-10-05', '1', 'Cras mi pede, malesuada in, imperdiet et, commodo vulputate, justo. In blandit ultrices enim. Lorem ipsum dolor sit amet, consectetuer adipiscing elit.', 8],
                ['2019-02-28', '3', 'Maecenas ut massa quis augue luctus tincidunt. Nulla mollis molestie lorem. Quisque ut erat.', 7],
                ['2019-07-04', '3', 'Aenean fermentum. Donec ut mauris eget massa tempor convallis. Nulla neque libero, convallis eget, eleifend luctus, ultricies eu, nibh.', 6],
                ['2019-07-30', '3', 'Curabitur in libero ut massa volutpat convallis. Morbi odio odio, elementum eu, interdum eu, tincidunt in, leo. Maecenas pulvinar lobortis est. Phasellus sit amet erat. Nulla tempus. Vivamus in felis eu sapien cursus vestibulum.', 5],
                ['2019-07-10', '4', 'Suspendisse potenti. In eleifend quam a odio. In hac habitasse platea dictumst.', 4],
                ['2019-09-15', '2', 'Duis bibendum. Morbi non quam nec dui luctus rutrum. Nulla tellus.', 3],
                ['2018-10-16', '3', 'Duis bibendum. Morbi non quam nec dui luctus rutrum. Nulla tellus. In sagittis dui vel nisl. Duis ac nibh. Fusce lacus purus, aliquet at, feugiat non, pretium quis, lectus.', 2],
                ['2019-02-13', '4', 'Integer tincidunt ante vel ipsum. Praesent blandit lacinia erat. Vestibulum sed magna at nunc commodo placerat.', 1],
            ]
        );
    }

    /**
     * @note
     * clean reviews
     */
    public function safeDown(): void
    {
        $this->delete(\frontend\models\Reviews::tableName());
    }
}
