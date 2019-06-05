Laravel RBAC and Annotations
===

This is a sample project. It's aim is to demonstrate creation of role based access control as annotations on methods

It makes authorization simpler and more evident. See example below:

```php
/**
     * @Post("/add/user")
     * @Only("permission:add_user")
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

Packages used are [laravelcollective/annotations](https://github.com/LaravelCollective/annotations) and [zizaco/entrust](https://github.com/Zizaco/entrust).
