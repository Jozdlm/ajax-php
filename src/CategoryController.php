<?php

class CategoryController
{

    function getCategories()
    {
        echo "categories";
    }

    function getCategoryById($id)
    {
        echo $id;
    }

    function createCategory()
    {
        echo "Category has been created";
    }

    function updateCategory(int|null $id)
    {
        if (!$id)
            echo "You must give an Id";

        echo $id;
    }

    function enableCategory(int|null $id)
    {
        if (!$id)
            echo "You must give an Id";

        echo $id;
    }

    function disableCategory(int|null $id)
    {
        if (!$id)
            echo "You must give an Id";

        echo $id;
    }
}

