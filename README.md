Laravel RBAC and Annotations
===

This is a sample project. It's aim is to create a role based access control on every method through annotations

The aim is to make authorization simpler and more evident. See example below:

```php
/**
     * @Post("/add/user")
     * @Permission("permission:add_user")
     *
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function addUser()
    {
    	//

        return response()->json([], 200);
    }
```

Used packages [laravelcollective/annotations](https://github.com/LaravelCollective/annotations) and [zizaco/entrust](https://github.com/Zizaco/entrust).
