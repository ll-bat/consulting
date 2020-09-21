class Spray {
    constructor(){
        this.current = [0,0]
        this.routes = []
    }
    
    addRoute(route){
        this.routes.push(route)
    }

    addNewRoute(){
        let radius  = rand(500)
        let speed   = random(3) + 1
        let tx      = random(2) > 1 ? 1 : -1
        let ty      = random(2) > 1 ? 1 : -1
        let scx     = random(2) 
        let scy     = random(2)
        let k       = rand(90)
        let p       = rand(90) + 10

        return [radius, speed, tx, ty, scx, scy, k, p]
    }

    runAnimation(frameFunc) {
        function frame(time){
              if (frameFunc() === true) return;
           requestAnimationFrame(frame);
        }
        requestAnimationFrame(frame);
    }  

    async start(){
         for (let i=0; i<this.routes.length;){
             let status = await this.run(this.routes[i])
             if (status == true) {
                 if (i == this.routes.length - 1){
                      this.routes[i] = this.addNewRoute()
                 }
                 else  i++
             }
         }
         
         console.log('finished')
    }

    run(route){
        let [radius,  // radius of circular path
             speed,   // by default, spray stops moving after 500 steps. by giving speed number of steps will be changed like this - steps = 500 / speed
             tx,      // +1 or -1 e.g. direction on x-axis (+1 - spray moves from left to right and vice versa)
             ty,      // +1 or -1 e.g. direction on y-axis
             scx,     // e.g. scaled X. distance on x-axis spray covers will be multiflied on scx, and this will cause elliptic movement
             scy,     // e.g. scaled Y. same way, distance on y-axis will be increased by scy times and this will change moving trajectory
             k = 0,       // e.g. Angle on clockwise
             p       // e.g. progress, should be in range [0, 100]. if p = 50, then spray stops moving when it covers 50% of its route 
            ] = route  

        let steps = 500 / speed 
        let currentStep = 1 
        let degree = 90 * (1 / steps) 
        let currentDegree = degree
        let dist = [0,0]
        let self = this
        let itsway = 180 * (p / 100)
        let x,y

        return new Promise(resolve => {
           self.runAnimation(() => {
                if (currentDegree >= itsway){
                    self.current[0] += dist[0]
                    self.current[1] += dist[1]
                    resolve(true)
                    return true 
                }

                else if (dist[0] + self.current[0] >= window.innerWidth || (dist[0] + self.current[0] < 0)){
                   
                    self.current[0] += dist[0]
                    self.current[1] += dist[1]

                    if (self.current[0] < 0) self.current[0] += 10
                    if (self.current[0] >= window.innerWidth) self.current[0] -= 10
                    resolve(true)
                    return true
                }

                else if (dist[1] + self.current[1] >= 800 || (dist[1] + self.current[1] <= -50)){
                    
                    self.current[0] += dist[0]
                    self.current[1] += dist[1]

                    if (self.current[1] <= -50) self.current[1] += 10
                    if (self.current[1] >= 800) self.current[1] -= 10
                    resolve(true)
                    return true
                }

                // let y  = radius * sin(currentDegree / 57)
                // let x  = radius * (1 - cos(currentDegree / 57))

                let hyp2 = 2 * radius * radius * (1 - cos(currentDegree / 57))
                let hyp  = sqrt(hyp2) 

                let deg2 = (180 - currentDegree) / 2
                let deg  = 180 - (deg2 + k)

                x = hyp * cos(deg / 57)
                y = hyp * sin(deg / 57)

                x = tx * x * scx 
                y = ty * y * scy 

                dist[0] = x
                dist[1] = y
                
                st($1(self.element), 
                    `tr:rotate(180deg) translateX(${x + self.current[0]}px) translateY(${y + self.current[1]}px)`)

                // st($1(self.element), 
                //     `l:-${x + self.current[0]}px; r:-${y + self.current[1]}px`)

                currentDegree += degree / 40
                currentDegree += degree * sin(currentStep / 57)

                currentStep = 180 * (currentDegree / itsway)

                return false
           })
        })
    }

    create(params){
        let [imagePath, uniqueId, parent] = params
        this.element = uniqueId 

        let c = `<div class='position-absolute'>
                       <img src='${imagePath}' class='spray' id='${uniqueId}' />
                  </div>`

        $1(parent).innerHTML = c + $1(parent).innerHTML
    }
}
